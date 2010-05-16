using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using soUtils;

namespace soClassNotify
{
    public partial class Form1 : Form
    {
        public Form1()
        {
            InitializeComponent();
        }

        private void Form1_Load(object sender, EventArgs e)
        {
            this.Opacity = 0;
        }

        private void timer1_Tick(object sender, EventArgs e)
        {
            soUtils.soMachineData MachineData = new soUtils.soMachineData();

            try
            {
                MachineData.getNotificationMessage();

                if (MachineData.Message != "")
                {
                    notifyIcon1.ShowBalloonTip(10000, "Switched On Classroom Alert", MachineData.Message,ToolTipIcon.Info);
                }

            }
            catch (Exception Error)
            {
            }


        }
    }
}