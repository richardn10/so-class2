using System;
using System.Collections.Generic;
using System.Text;
using MySql.Data.MySqlClient;
using System.Management;
using Microsoft.Win32;
using System.Diagnostics;



namespace soUtils
{
    public class soMachineData
    {
        private Boolean isLogoff;
        private string strMessage;

        public Boolean Logoff
        {
            get
            {
                return isLogoff;
            }

            set
            {
                isLogoff = value;
            }
        }

        public string Message
        {
            get
            {
                return strMessage;
            }

            set
            {
                strMessage = value;
            }

        }

        public void CheckComputer()
        {
            string strMachineName;
            string MyConString;
            string strdbServer;
            string strUsername;
            DateTime dtLogoff, dtLogon;
            int iMinutes, iElapsed = 0;
            string strSQL;
            MySqlCommand cmd;
            MySqlConnection cn;
            long lReturn;
            RegistryKey rkCurr = Registry.LocalMachine.OpenSubKey("Software\\SwitchedOn");
            int iDev;
            string strMinutes;
            TimeSpan tsElapsed;

            //ManagementObject wmiWorkstation;

            try
            {

                EventLog evLog;

                evLog = new EventLog("Security");
                //Get the name of this machine
                strMachineName = System.Environment.MachineName;
                EventLog.WriteEntry("SwitchedOn Classroom Timer", "The machine name is: " + strMachineName);
                iDev = (int)rkCurr.GetValue("isDev");
                strUsername = (string)rkCurr.GetValue("username");
                EventLog.WriteEntry("SwitchedOn Classroom Timer", "isDev =  " + (iDev == 1 ? "True" : "False"));
                EventLog.WriteEntry("SwitchedOn Classroom Username", strUsername);
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
                    if ((ele.InstanceId == 4647) && (ele.TimeGenerated > dtLogoff) && (ele.Message.ToLower().Contains(strUsername)))
                    {
                        dtLogoff = ele.TimeGenerated;
                    }
                    else
                    {
                        //We are looking for the most recent logon event for the 
                        //student
                        if ((ele.InstanceId == 4624) && (ele.TimeGenerated > dtLogon) && (ele.Message.ToLower().Contains(strUsername)))
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
                    "DATABASE=so_class;" +
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
                        Logoff = true;
                    }
                    else
                    {
                        Logoff = false;

                    }

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

        public void getNotificationMessage()
        {
            string strMachineName;
            string MyConString;
            string strdbServer;
            string strUsername;
            DateTime dtLogoff, dtLogon;
            int iMinutes, iRemaining, iElapsed = 0;
            string strSQL;
            MySqlCommand cmd;
            MySqlConnection cn;
            long lReturn;
            RegistryKey rkCurr = Registry.LocalMachine.OpenSubKey("Software\\SwitchedOn");
            int iDev;
            string strMinutes;
            TimeSpan tsElapsed;

            //ManagementObject wmiWorkstation;

            try
            {
                Message = "";
                EventLog evLog;
                //Get the name of this machine
                evLog = new EventLog("Security");
                strMachineName = System.Environment.MachineName;
                iDev = (int)rkCurr.GetValue("isDev");
                strUsername = (string)rkCurr.GetValue("username");
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
                    if ((ele.InstanceId == 4647) && (ele.TimeGenerated > dtLogoff) && (ele.Message.ToLower().Contains(strUsername)))
                    {
                        dtLogoff = ele.TimeGenerated;
                    }
                    else
                    {
                        //We are looking for the most recent logon event for the 
                        //student
                        if ((ele.InstanceId == 4624) && (ele.TimeGenerated > dtLogon) && (ele.Message.ToLower().Contains(strUsername)))
                        {
                            dtLogon = ele.TimeGenerated;
                            //Calculate the time that's elapsed since the last logon
                            tsElapsed = DateTime.Now - dtLogon;
                            iElapsed = (int)tsElapsed.TotalMinutes;
                        }
                    }

                }
                //If the last login was later than the last logout then check how much time the
                //facilitator has allowed for this machine 
                if (dtLogon.Ticks > dtLogoff.Ticks)
                {
                    strdbServer = rkCurr.GetValue("dbServer").ToString();
                    MyConString = "SERVER=" + strdbServer + ";" +
                    "DATABASE=so_class;" +
                    "UID=so_admin;" +
                    "PASSWORD=so_admin;";
                    cn = new MySqlConnection(MyConString);
                    cmd = new MySqlCommand();
                    strSQL = "select iMinutes from tblWorkstation where strWorkstation = '" + strMachineName + "';";
                    cmd.CommandText = strSQL;
                    iMinutes = Convert.ToInt32(cmd.ExecuteScalar());
                    cn.Close();
                    EventLog.WriteEntry("SwitchedOn Classroom Timer", "The time allowed is: " + iMinutes.ToString());
                    //If fewer than 5 minutes of the user's time remains then warn them
                    iRemaining = (int)(dtLogon.AddMinutes((double)iMinutes) - DateTime.Now).TotalMinutes;

                    if (iRemaining <= 5)
                    {
                        Message = "Your computer will be logged off in approximately " + iRemaining.ToString() + " minutes.  Please save your work.";
                    }

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
