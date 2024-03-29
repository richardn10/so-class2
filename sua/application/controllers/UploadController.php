<?php

class UploadController extends Zend_Controller_Action
{
    /*
     * The maximum number of works processed by 1 process Action
     */
    const MAX_WORKS_PER_RUN = 20;

    /*
     * Convenience variable (to not every time call getInvokeArg('bootstrap')
     */
    private $_bootstrap;

    public function init()
    {
        // init bootstrap variable
        $this->_bootstrap = $this->getInvokeArg('bootstrap');

        // Make the submit action returning xml output
        $contextSwitch = $this->_helper->getHelper('contextSwitch');
        $contextSwitch->addActionContext('submit', 'xml')
            ->initContext();
    }

    public function processAction()
    {
        //TODO: This action should be only cli accesible (or password protected)

        // get pid and check or a previous run with this script did not clean up
        $pid = getmypid();
        $works = Work::findByPidAndFinished($pid, false);

        // clean up
        foreach($works as $work) {
            $work->current_pid = null;
            $work->save();
        }

        // array for making sure that we process every work only once (per script-run).
        // Avoids endless loops when the works fail
        $excludeWorks = array();
        $cnt = 0;
        while(++$cnt < self::MAX_WORKS_PER_RUN) {
            //request a work item
            Work::setWorksToPid($pid, 1, $excludeWorks);
            $works = Work::findByPidAndFinished($pid, false, true);

            // if no works are found, return
            if(count($works) == 0) break;

            // do processing
            $fileProcessor = $this->_bootstrap->getResource('fileprocessor');

            foreach($works as $work) {
                echo "Start processing work: ".$work->id."<br>\n";
                $fileProcessor->process($work);
                $fileProcessor->releaseWork($work);
                $excludeWorks[] = $work->id;

            }
        }
    }

    public function cleanAction()
    {
        throw new Exception("Not in use yet");
    }

    public function indexAction()
    {

        if(!$this->_hasParam('file_id')
            || !$this->_hasParam('form_pending_id')
            || !$this->_hasParam('title')
            || !$this->_hasParam('description')
            || !$this->_hasParam('timestamp')
            || !$this->_hasParam('token')
            || !$this->_hasParam('return_url')
            || !$this->_hasParam('return_element')
            || !$this->_hasParam('filetype')
        ) {
            throw new Exception('Not all parameters are provided');
        }

        if(!$this->_bootstrap->getResource('intalio')->validateIncomingToken(
            $this->_getParam('token'),
            $this->_getParam('file_id'),
            $this->_getParam('timestamp')
        ) ) {
            throw new Exception('Token not valid');
        }

        // pass on all current parameters to the form submit. The form submit is ajaxified, so we want to return xml.
        $formActionParams = $this->getRequest()->getParams();
        $formActionParams['action'] = 'submit';
        $formActionParams['format'] = 'xml';

        $this->view->formActionParams = array_map('rawurlencode',$formActionParams);
        $this->view->return_url = $formActionParams['return_url'];
        $this->view->nosuccess = true;

        $this->view->form = new Form_Upload();
    }

    public function submitAction()
    {
        try {
            $this->view->success = true;
            $this->view->message = '';

            if(!$this->_hasParam('file_id')
                || !$this->_hasParam('form_pending_id')
                || !$this->_hasParam('title')
                || !$this->_hasParam('description')
                || !$this->_hasParam('timestamp')
                || !$this->_hasParam('token')
                || !$this->_hasParam('return_url')
                || !$this->_hasParam('return_element')
                || !$this->_hasParam('filetype')
            ) {
                $this->view->success = false;
                $this->view->message ="Not all parameters are provided";
                return;
            }

            if(!$this->_bootstrap->getResource('intalio')->validateIncomingToken(
                $this->_getParam('token'),
                $this->_getParam('file_id'),
                $this->_getParam('timestamp')
            ) ) {
                $this->view->success = false;
                $this->view->message ="Token not valid";
                return;
            }

            $form = new Form_Upload();
            if(!$this->getRequest()->isPost()) {
                $this->view->success = false;
                $this->view->message ="Wrong protocol";
                return;
            }


            if( $this->_getParam('filetype') == 'image') {
                $form->file->addValidator('MimeType', true, array('image/jpeg', 'image/pjpeg','image/gif','image/png'));
            } elseif( $this->_getParam('filetype') == 'video') {
                $form->file->addValidator('MimeType', true, array('video/x-msvideo', 'video/x-flv'));
            } else {
                $this->view->success = false;
                $this->view->message = "Not a valid filetype (".$this->_getParam('filetype').")";
                return;
            }

            if (!$form->isValid($this->getRequest()->getPost()))
            {
                $this->view->success = false;
                $messages = $form->getMessages();
                $messageStrings = array();
                foreach($messages as $messageArray)
                $messageStrings[] = implode(', ',$messageArray);

                $this->view->message = implode(', ',$messageStrings);
                return;
            }

            try {
                $form->file->receive();
            }
            catch (Zend_File_Transfer_Exception $e)
            {
                $this->view->success = false;
                $this->view->message = $e->getMessage();
                return;
            }

            $fileinfo = $form->file->getFileInfo();

            $newFilename = $this->_bootstrap->getResource('intalio')->getRandomString().'.'.$this->getExtension($fileinfo['file']['type']);
            $newFullFilename = APPLICATION_PATH ."/../data/queue/".$newFilename;
            rename($form->file->getFilename(), $newFullFilename);

            $work = new Work();
            $work->file_id = $this->_getParam('file_id');
            $work->form_pending_id = $this->_getParam('form_pending_id');
            $work->title= rawurldecode($this->_getParam('title'));
            $work->description = rawurldecode($this->_getParam('description'));
            $work->file_name = $newFilename;
            $work->file_type = $this->_getParam('filetype');
            $work->file_mimetype = $fileinfo['file']['type'];
            $work->current_pid = getmypid();
            $work->save();


            $fileProcessor = $this->_bootstrap->getResource('fileprocessor');
            $fileProcessor->processOneAction($work, 'receive_media');
            $fileProcessor->processOneAction($work, 'make_thumbnail');
            $fileProcessor->releaseWork($work);

            $this->view->filename = $newFilename;
            $this->view->thumbnail = $work->thumbnail_file_name;

            $this->view->message = "";
        } catch (Exception $e) {

        }
    }

    public function statusAction()
    {
        $works = Work::findAll();
        $this->view->works = $works;
    }


    public function testtokenAction()
    {
        $this->view->timestamp = $timestamp = time();
        $this->view->attachmentId = $attachmentId = rand(10000000, 99999999);
        $this->view->token = $this->_bootstrap->getResource('intalio')->getIncomingToken($attachmentId, $timestamp);
        $this->view->filetype = 'image';
    }

    public function getExtension($mimeType)
    {
        switch($mimeType) {
            case 'image/jpeg':
            case 'image/pjpeg':
                return 'jpg';
                break;
            case 'image/png':
                return 'png';
                break;
            case 'image/gif':
                return 'gif';
                break;
            case 'video/x-msvideo':
                return 'avi';
                break;
            case 'video/x-flv':
                return 'flv';
                break;
            default:
                throw new Exception('Unknown MimeType: '.$mimeType);
        }

    }

}