using System;
using System.Diagnostics;
using System.ServiceProcess;
using MySql.Data.MySqlClient;
using System.Management;
using Microsoft.Win32;

namespace so_classTimer
{
    class so_classTimer : ServiceBase
    {
        /// <summary>
        /// Public Constructor for WindowsService.
        /// - Put all of your Initialization code here.
        /// </summary>
        System.Threading.Thread t = null;
        System.Threading.ThreadStart ts = null;

        public so_classTimer()
        {
            this.ServiceName = "SwitchedOn Classroom Timer";
            this.EventLog.Source = "SwitchedOn Classroom Timer";
            this.EventLog.Log = "Application";

            // These Flags set whether or not to handle that specific
            //  type of event. Set to true if you need it, false otherwise.
            this.CanHandlePowerEvent = true;
            this.CanHandleSessionChangeEvent = true;
            this.CanPauseAndContinue = true;
            this.CanShutdown = true;
            this.CanStop = true;

            if (!EventLog.SourceExists("SwitchedOn Classroom Timer"))
                EventLog.CreateEventSource("SwitchedOn Classroom Timer", "Application");
        }

        /// <summary>
        /// The Main Thread: This is where your Service is Run.
        /// </summary>
        static void Main()
        {
            ServiceBase.Run(new so_classTimer());
        }

        /// <summary>
        /// Dispose of objects that need it here.
        /// </summary>
        /// <param name="disposing">Whether or not disposing is going on.</param>
        protected override void Dispose(bool disposing)
        {
            base.Dispose(disposing);
        }

        /// <summary>
        /// OnStart(): Put startup code here
        ///  - Start threads, get inital data, etc.
        /// </summary>
        /// <param name="args"></param>
        protected override void OnStart(string[] args)
        {           
            ts = new System.Threading.ThreadStart(serviceTask);
            t = new System.Threading.Thread(ts);

            t.Start();
            //base.OnStart(args);
        }

        /// <summary>
        /// OnStop(): Put your stop code here
        /// - Stop threads, set final data, etc.
        /// </summary>
        protected override void OnStop()
        {
            base.OnStop();
        }

        /// <summary>
        /// OnPause: Put your pause code here
        /// - Pause working threads, etc.
        /// </summary>
        protected override void OnPause()
        {
            base.OnPause();
        }

        /// <summary>
        /// OnContinue(): Put your continue code here
        /// - Un-pause working threads, etc.
        /// </summary>
        protected override void OnContinue()
        {
            base.OnContinue();
        }

        /// <summary>
        /// OnShutdown(): Called when the System is shutting down
        /// - Put code here when you need special handling
        ///   of code that deals with a system shutdown, such
        ///   as saving special data before shutdown.
        /// </summary>
        protected override void OnShutdown()
        {
            base.OnShutdown();
        }

        /// <summary>
        /// OnCustomCommand(): If you need to send a command to your
        ///   service without the need for Remoting or Sockets, use
        ///   this method to do custom methods.
        /// </summary>
        /// <param name="command">Arbitrary Integer between 128 & 256</param>
        protected override void OnCustomCommand(int command)
        {
            //  A custom command can be sent to a service by using this method:
            //#  int command = 128; //Some Arbitrary number between 128 & 256
            //#  ServiceController sc = new ServiceController("NameOfService");
            //#  sc.ExecuteCommand(command);

            base.OnCustomCommand(command);
        }

        /// <summary>
        /// OnPowerEvent(): Useful for detecting power status changes,
        ///   such as going into Suspend mode or Low Battery for laptops.
        /// </summary>
        /// <param name="powerStatus">The Power Broadcast Status
        /// (BatteryLow, Suspend, etc.)</param>
        protected override bool OnPowerEvent(PowerBroadcastStatus powerStatus)
        {
            return base.OnPowerEvent(powerStatus);
        }

        /// <summary>
        /// OnSessionChange(): To handle a change event
        ///   from a Terminal Server session.
        ///   Useful if you need to determine
        ///   when a user logs in remotely or logs off,
        ///   or when someone logs into the console.
        /// </summary>
        /// <param name="changeDescription">The Session Change
        /// Event that occured.</param>
        protected override void OnSessionChange(
                  SessionChangeDescription changeDescription)
        {
            base.OnSessionChange(changeDescription);
        }
        /// <summary>
        /// serviceTask(): This performs the main work
        /// Get the time of the last logon
        /// Check it against the lesson duration (in the database)
        /// Logoff the user if required
        /// </summary>        
        public static void serviceTask()
        {
            string strMachineName;
            string MyConString;
            string strdbServer;
            DateTime dtLogoff, dtLogon;
            int iMinutes, iElapsed = 0;
            string strSQL;
            MySqlCommand cmd;
            MySqlConnection cn;
            ManagementObjectSearcher wmiObj;
            ManagementClass processClass = new ManagementClass("Win32_OperatingSystem");
            long lReturn;
            ManagementBaseObject wmiReturn = null;
            RegistryKey rkCurr = Registry.LocalMachine.OpenSubKey("Software\\SwitchedOn");
            int iDev;
            string strMinutes;
            ManagementBaseObject inParams = processClass.GetMethodParameters("Win32Shutdown");
            TimeSpan tsElapsed;

            //ManagementObject wmiWorkstation;

            try
            {

                while (true)
                {
                    EventLog evLog;

                    evLog = new EventLog("Security");
                    //Get the name of this machine
                    strMachineName = System.Environment.MachineName;
                    EventLog.WriteEntry("SwitchedOn Classroom Timer", "The machine name is: " + strMachineName);
                    iDev = (int)rkCurr.GetValue("isDev");
                    EventLog.WriteEntry("SwitchedOn Classroom Timer", "isDev =  " + (iDev == 1 ? "True" : "False"));
                    //Interrogate the event log to find the time of the last logout and the last login
                    dtLogoff = new DateTime(1990, 1, 1);
                    dtLogon = new DateTime(1990, 1, 1);
                    //Logoff event ID = 4647
                    //Logon event ID = 4624
                    foreach (EventLogEntry ele in evLog.Entries)
                    {
                        //We are looking for the most recent logoff event for the user.
                        //This requires a hard-coded username to identify the student
                        //All machines will need to be logged on with the same username
                        if ((ele.InstanceId == 4647) && (ele.TimeGenerated > dtLogoff) && (ele.Message.ToLower().Contains("edward")))
                        {
                            dtLogoff = ele.TimeGenerated;
                        }
                        else
                        {
                            //We are looking for the most recent logon event for the 
                            //student
                            if ((ele.InstanceId == 4624) && (ele.TimeGenerated > dtLogon) && (ele.Message.ToLower().Contains("edward")))
                            {
                                dtLogon = ele.TimeGenerated;
                                //Calculate the time that's elapsed since the last logon
                                tsElapsed = DateTime.Now - dtLogon;
                                iElapsed = (int)tsElapsed.TotalMinutes;
                            }
                        }

                    }
                    //These two logs are for testing purposes
                    EventLog.WriteEntry("SwitchedOn Classroom Timer", "The last logoff was: " + dtLogoff.ToLongTimeString());
                    EventLog.WriteEntry("SwitchedOn Classroom Timer", "The last logon was: " + dtLogon.ToLongTimeString());
                    //If the last login was later than the last logout then check how much time the
                    //facilitator has allowed for this machine 
                    if (dtLogon.Ticks > dtLogoff.Ticks)
                    {
                        strdbServer = rkCurr.GetValue("dbServer").ToString();
                        EventLog.WriteEntry("SwitchedOn Classroom Timer", "The server IP address is: " + strdbServer);
                        MyConString = "SERVER=" + strdbServer + ";" +
                        "DATABASE=soclass;" +
                        "UID=so_admin;" +
                        "PASSWORD=so_admin;";
                        cn = new MySqlConnection(MyConString);
                        strSQL = "update tblWorkstation set dtLastContact = now(), iElapsed = " + iElapsed.ToString() + " where strWorkstation = '" + strMachineName + "';";
                        cmd = new MySqlCommand(strSQL, cn);
                        cn.Open();
                        cmd.ExecuteNonQuery();
                        strSQL = "select iMinutes from tblWorkstation where strWorkstation = '" + strMachineName + "';";
                        cmd.CommandText = strSQL;
                        iMinutes = Convert.ToInt32(cmd.ExecuteScalar());
                        cn.Close();
                        EventLog.WriteEntry("SwitchedOn Classroom Timer", "The time allowed is: " + iMinutes.ToString());
                        //If the time has been exceeded then logoff this machine
                        if (dtLogon.AddMinutes((double)iMinutes) < DateTime.Now)
                        {
                            EventLog.WriteEntry("SwitchedOn Classroom Timer", "The time allowed has been exceeded");
                            //Locate this workstation.  The only way to do this is to query the collection of computers
                            //in WMI, even though there will be only one computer there
                            wmiObj = new ManagementObjectSearcher("Select * from Win32_OperatingSystem");

                            foreach (ManagementObject wmiWorkstation in wmiObj.Get())
                            {
                                inParams["Flags"] = "0";
                                inParams["Reserved"] = "0";
                                EventLog.WriteEntry("SwitchedOn Classroom Timer", "Logging off");

                                if (iDev != 1)
                                {
                                    wmiReturn = wmiWorkstation.InvokeMethod("Win32Shutdown", inParams, null);

                                    if (wmiReturn["ReturnValue"] != "0")
                                    {
                                        EventLog.WriteEntry("SwitchedOn Classroom Timer", "The logoff method returned " + wmiReturn["ReturnValue"]);
                                    }

                                }

                            }
                        }
                        else
                        {
                            //If fewer than 5 minutes of the user's time remains then warn them
                            if ((dtLogon.AddMinutes((double)iMinutes) - DateTime.Now).TotalMinutes <= 5)
                            {
                                //TODO: Notify the user
                            }

                        }

                    }
                    //This procedure will run at timed intervals (expressed in milliseconds)
                    System.Threading.Thread.Sleep(
                        5 /* Minutes */ * 60 /* Seconds */ * 1000 /* Milliseconds */);

                }

            }
            catch (Exception Error)
            {
                if (Error is System.Threading.ThreadAbortException)
                    return;
                else
                {
                    // Do your error handling here.
                    EventLog.WriteEntry("SwitchedOn Classroom Timer", "The following error occurred: " + Error.Message);
                }

            }

        }


    }
}
