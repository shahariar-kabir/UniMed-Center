Add-Type -AssemblyName System.Drawing

# Create 32x32 bitmap
$bmp = New-Object System.Drawing.Bitmap 32, 32
$g = [System.Drawing.Graphics]::FromImage($bmp)
$g.SmoothingMode = [System.Drawing.Drawing2D.SmoothingMode]::AntiAlias
$g.TextRenderingHint = [System.Drawing.Text.TextRenderingHint]::AntiAliasGridFit

# Outer Green Background
$greenBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.ColorTranslator]::FromHtml('#134d2a'))
$g.FillRectangle($greenBrush, 0, 0, 32, 32)

# Gold Outer Border
$goldPen = New-Object System.Drawing.Pen ([System.Drawing.ColorTranslator]::FromHtml('#c8922a')), 1.5
$g.DrawRectangle($goldPen, 1, 1, 30, 30)

# White Rounded Badge
$whiteBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.Color]::White)
$g.FillRectangle($whiteBrush, 4, 4, 24, 24)

# White Badge Gold Border
$innerGoldPen = New-Object System.Drawing.Pen ([System.Drawing.ColorTranslator]::FromHtml('#c8922a')), 1.0
$g.DrawRectangle($innerGoldPen, 4, 4, 23, 23)

# Draw "UMC" text
$font = New-Object System.Drawing.Font ("Arial", 8.5, [System.Drawing.FontStyle]::Bold)
$textBrush = New-Object System.Drawing.SolidBrush ([System.Drawing.ColorTranslator]::FromHtml('#1a6b3a'))
$sf = New-Object System.Drawing.StringFormat
$sf.Alignment = [System.Drawing.StringAlignment]::Center
$sf.LineAlignment = [System.Drawing.StringAlignment]::Center

$rect = New-Object System.Drawing.RectangleF 4, 4, 24, 24
$g.DrawString("UMC", $font, $textBrush, $rect, $sf)

$g.Dispose()

# Save ICO
$hIcon = $bmp.GetHicon()
$icon = [System.Drawing.Icon]::FromHandle($hIcon)
$fs = [System.IO.File]::Create("d:\AndroidStudioProjects\university_medical_center_management_system\public\favicon.ico")
$icon.Save($fs)
$fs.Close()
$bmp.Dispose()

Write-Host "UMC Favicon ICO generated successfully"
