Go back to [Payment and Logout](Workpackage_PaymentAndLogout.md)

# Introduction #

The soClassTimer service is a Windows Service that logs off a user from a workstation after a designated period of time has elapsed.

This page describes the work done to date (04/10/2009).

## SVN Details ##

The source code is in the so\_classTimer folder.  The service has been written in C# using version 2.0 of the .Net Framework.

## Installing the Service ##

After the code has been compiled the service must be registered on the machine so that it appears in the list of services.  To do that, place the regsvc.bat file in the same folder as the so\_classTimer.exe file and run it.  To remove the service, do the same with unregsvc,bat.

## Current Functionality ##

This code is found in the serviceTask function.

1. Get the name of the computer.

2. Search the event log for the most recent logoff event (event code 4647) for the user.

3. Search the event log for the most recent logon event (event code 4624) for the user.

4. Continue if the logon time was later than the logoff time.

5. Connect to the so\_class database on the server.

6. Update a timestamp in tblWorkstation so that the administrator knows that the service is still alive.

7. Store the time elapsed since the logon in tblWorkstation so that the administrator can tell if the user has prevented the service from loggin them off.

8. select iMinutes from tblWorkstation where strWorkstation = this workstation name.

9. If the time elapsed since the last logon has exceeded what is defined in tblworkstation then continue.

10. Use WMI to connect to the workstation.

11. Send a Win32Shutdown command to logoff the machine.


## ToDo List ##

1. Warn the user 5 minutes before logging off.  The plan is to create a tray notification application and use .Net Remoting to communicate between that and the service.
2. Allow different logon names to be used on the workstations, rather than a single predefined one