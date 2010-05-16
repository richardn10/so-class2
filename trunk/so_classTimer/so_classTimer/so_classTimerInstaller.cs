using System;
using System.ComponentModel;
using System.Configuration.Install;
using System.ServiceProcess;

namespace so_classTimer
{
    [RunInstaller(true)]
    public class so_classTimerInstaller : Installer
    {
        /// <summary>
        /// Public Constructor for WindowsServiceInstaller.
        /// - Put all of your Initialization code here.
        /// </summary>
        public so_classTimerInstaller()
        {
            ServiceProcessInstaller serviceProcessInstaller = new ServiceProcessInstaller();
            ServiceInstaller serviceInstaller = new ServiceInstaller();

            //# Service Account Information
            serviceProcessInstaller.Account = ServiceAccount.LocalSystem;
            serviceProcessInstaller.Username = null;
            serviceProcessInstaller.Password = null;

            //# Service Information
            serviceInstaller.DisplayName = "SwitchedOn Classroom Timer";
            serviceInstaller.StartType = ServiceStartMode.Automatic;

            //# This must be identical to the so_classTimer.ServiceBase name
            //# set in the constructor of so_classTimer.cs
            serviceInstaller.ServiceName = "SwitchedOn Classroom Timer";

            this.Installers.Add(serviceProcessInstaller);
            this.Installers.Add(serviceInstaller);
        }
    }
}