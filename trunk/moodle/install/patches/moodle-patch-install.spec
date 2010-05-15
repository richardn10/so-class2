%define patch %(echo $PATCH)

Name:      moodle
Summary:   The Moodle package for Switched-On installations.
Version:   %{ver}
Release:   %{patch}
License:   GPL
Vendor:    Switched-On
Packager:  so
Group:     Applications/Productivity
Source0:   %{name}-patch-install_%{release}.tar.gz
BuildRoot: %{_tmppath}/%{name}-patch-install_%{release}-build
Requires:  sharutils
Requires:  apache2
Requires:  mysql

#%define patch %(echo $PATCH)

%description
Bespoke Moodle installation for Switched-On project.

%prep
%setup -c

%build

%install
%__rm -rf %{buildroot}
%__mkdir -p %{buildroot}/%{shardir}
%__mv %{_builddir}/%{name}-%{version}/%{name}-patch-install_%{release}.sh %{buildroot}/%{shardir}

%clean
%__rm -rf %{buildroot}

%post
source /etc/so.conf
./%{shardir}/%{name}-patch-install_%{release}.sh $USERNAME $PASSWORD $WWWDIR $WWWDIROWNER $WWWDIRPERMS

%postun

%files
/%{shardir}/%{name}-patch-install_%{release}.sh
