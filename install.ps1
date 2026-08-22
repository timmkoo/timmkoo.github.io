# ============================================================
# install.ps1 – Install 7‑Zip and spawn an admin command prompt
# Usage via IEX:
#   powershell -c "IEX (New-Object Net.WebClient).DownloadString('http://your-server/install.ps1')"
# ============================================================

# 1. Silent install of 7‑Zip (64‑bit)
$7zipUrl = "https://www.7-zip.org/a/7z2409-x64.exe"
$installer = "$env:TEMP\7zinstall.exe"
(New-Object Net.WebClient).DownloadFile($7zipUrl, $installer)
Start-Process -FilePath $installer -ArgumentList "/S" -Wait

# 2. Provide an admin command prompt
#    Option A: Launch a new PowerShell window as Administrator
Start-Process powershell -Verb RunAs -ArgumentList "-NoExit", "-Command", "Write-Host 'Admin PowerShell ready' -ForegroundColor Green; $host.UI.RawUI.WindowTitle='Admin Prompt'"

#    Option B: Launch classic cmd.exe as Administrator (uncomment below)
# Start-Process cmd -Verb RunAs

#    Option C: Fetch an additional script from a URL and run it as admin
# $adminScriptUrl = "https://your-server/admin.ps1"
# $adminScript = "$env:TEMP\admin.ps1"
# (New-Object Net.WebClient).DownloadFile($adminScriptUrl, $adminScript)
# Start-Process powershell -Verb RunAs -ArgumentList "-File", $adminScript