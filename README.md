READ ME
Hello everybody

That's a code to communicate with agilent 34410A.
I write just to do measurements, but you can change code to configurate, etc...All commands of 34410A_Quick_Reference.pdf

To connect
On Agilent : Connect LAN with your network (cable Ethernet)
Shift:Utility->Remote I/O -> LAN -> YES -> View
Wait a minute to configuration and read IP address.
With your server (if local with your PC, with install apache server, with XAMPP for exemple), configure card network with Agilent IP (exemple 169.254.102.50 if Agilent IP is 169.254.102.195)
And let's go.

Mesure
Each second, one mesure, graphic is refresh with AJAX, and data is save on file.
You can add other input for easier configuration.

![PrintScreen](https://github.com/Shmuel83/Agilent34410A/blob/master/printscreen2.png)
