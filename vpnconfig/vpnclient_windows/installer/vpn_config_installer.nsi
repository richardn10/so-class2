!include MUI2.nsh


!define HOME "openvpn"

OutFile "switchedon_vpn_config.exe"

InstallDir "$PROGRAMFILES\OpenVPN"

!insertmacro MUI_PAGE_COMPONENTS
!insertmacro MUI_PAGE_DIRECTORY
!insertmacro MUI_PAGE_INSTFILES
!insertmacro MUI_PAGE_FINISH
!insertmacro MUI_UNPAGE_CONFIRM
!insertmacro MUI_UNPAGE_INSTFILES

Section "-General"
  SetOverwrite on
  SetOutPath $INSTDIR
  writeUninstaller "$INSTDIR\uninstall_switchedon_vpn_config.exe"
  SetOutPath "$INSTDIR\config\mycert"  
  File "mycert\mycert.exe"

  WriteRegStr HKLM "SOFTWARE\OpenVPN-GUI" "config_dir" '$INSTDIR\config'
SectionEnd

Section "Support Config"
  SetOverwrite on
  SetOutPath "$INSTDIR\config\switchedon_support_keys"
  File "support_files\ca.crt"

  SetOutPath "$INSTDIR\config\mycert"  
  File "mycert\support.ini"
  File "support_files\support_template.ovpn"
  
  WriteINIStr "$INSTDIR\config\mycert\support.ini" "openvpn" "template" "$INSTDIR\config\mycert\support_template.ovpn" 
  WriteINIStr "$INSTDIR\config\mycert\support.ini" "paths" "dir" "$INSTDIR\config\switchedon_support_keys"

  FileOpen $R0 "$INSTDIR\config\mycert\support.bat" w
  FileWrite $R0 "del $\"$INSTDIR\config\switchedon_support_keys\*.ovpn$\"$\r$\n"
  FileWrite $R0 "copy $\"$INSTDIR\config\mycert\support.ini$\" $\"$INSTDIR\config\mycert\mycert.ini$\"$\r$\n"
  FileWrite $R0 "$\"$INSTDIR\config\mycert\mycert.exe$\"$\r$\n"
  FileWrite $R0 "del $\"$INSTDIR\config\mycert\mycert.ini$\"$\r$\n"
  FileWrite $R0 "move $\"$INSTDIR\config\switchedon_support_keys\*.ovpn$\" $\"$INSTDIR\config\switchedon_support_vpn.ovpn$\"$\r$\n"
  FileClose $R0

  CreateShortcut "$SMPROGRAMS\Switchedon VPN\Create Support Config.lnk" "$INSTDIR\config\mycert\support.bat"

  
SectionEnd


Section "Developer Config"
  SetOverwrite on
  SetOutPath "$INSTDIR\config\switchedon_dev_keys"
  File "dev_files\ca.crt"

  SetOutPath "$INSTDIR\config\mycert"  
  File "mycert\dev.ini"
  File "dev_files\dev_template.ovpn"

  WriteINIStr "$INSTDIR\config\mycert\dev.ini" "openvpn" "template" "$INSTDIR\config\mycert\dev_template.ovpn" 
  WriteINIStr "$INSTDIR\config\mycert\dev.ini" "paths" "dir" "$INSTDIR\config\switchedon_dev_keys"

  FileOpen $R0 "$INSTDIR\config\mycert\dev.bat" w
  FileWrite $R0 "del $\"$INSTDIR\config\switchedon_dev_keys\*.ovpn$\"$\r$\n"
  FileWrite $R0 "copy $\"$INSTDIR\config\mycert\dev.ini$\" $\"$INSTDIR\config\mycert\mycert.ini$\"$\r$\n"
  FileWrite $R0 "$\"$INSTDIR\config\mycert\mycert.exe$\"$\r$\n"
  FileWrite $R0 "del $\"$INSTDIR\config\mycert\mycert.ini$\"$\r$\n"
  FileWrite $R0 "move $\"$INSTDIR\config\switchedon_dev_keys\*.ovpn$\" $\"$INSTDIR\config\switchedon_dev_vpn.ovpn$\"$\r$\n"
  FileClose $R0

  CreateShortcut "$SMPROGRAMS\Switchedon VPN\Create Developer Config.lnk" "$INSTDIR\config\mycert\dev.bat"

SectionEnd


section "un.General"
  Delete "$INSTDIR\uninstall_switchedon_vpn_config.exe"
  Delete "mycert\mycert.exe"
  RMDir "$SMPROGRAMS\Switchedon VPN"
sectionEnd

Section "un.Support Config"
  Delete "$INSTDIR\config\switchedon_support_keys\ca.crt"
  Delete "$INSTDIR\config\mycert\support.ini"
  Delete "$INSTDIR\config\mycert\support.bat"
  Delete "$INSTDIR\config\support_files\support_template.ovpn"
  
  Delete "$SMPROGRAMS\Switchedon VPN\Create Support Config.lnk"
  

SectionEnd


Section "un.Developer Config"
  Delete "$INSTDIR\config\switchedon_dev_keys\ca.crt"
  Delete "$INSTDIR\config\mycert\dev.ini"
  Delete "$INSTDIR\config\mycert\dev.bat"
  Delete "$INSTDIR\config\dev_files\dev_template.ovpn"

  Delete "$SMPROGRAMS\Switchedon VPN\Create Developer Config.lnk"
SectionEnd


