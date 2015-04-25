Go back to [Video and Performance](Workpackage_VideoAndPerformance.md)

# Introduction #

Investigation of possibilities for how to playback video files across multiple clients... with the added 'fun' task of synchronising said playback.

# Using VNC #

A possibility, as maybe (?) would remove the synchronicity problems.

# Using X-Windows #

This would be ideal if the full thin-client model were to be used.

Specifically (especially for non-thin-client), one of the extensions available.
http://en.wikipedia.org/wiki/X_Window_System_protocols_and_architecture#Extensions

# Specific flash-based server #

See this link for a guy who's already proved this is possible: http://www.bryanchung.net/?p=240

His example is based upon: http://www.processing.org/reference/libraries/net/Server.html

Therefore, the idea behind this approach is for something central on the server that would:
  * take a particular video file from the server,
  * be connected to from the required clients,
  * receive constant updates from the 'master' client as to the position it's at,
  * notify the 'slave' clients to update their video position to the master's.
In doing so, if any slaves lag behind, they will be (relatively) immediately told to catch up!

More links/info on coding this approach:
  * It would (most likely) require the use of this Java library: http://processing.org/ (see also http://dev.processing.org/). I only say this because this is what the above example uses.
  * For a more in-depth example of using the Processing Java library for our purposes: http://www.mikkoh.com/blog/?p=50
> > (Note that this does not stream a video file, however it does show more of how to use the library.)
  * Other open-source projects exist which **might** do the basics of what we require. However by the time we investigate each and modify as required, it's probably quicker to write from scratch exactly what we need (and code 'ownership', maintainability, etc. would be better for us).
> > For these other projects, see the 'Servers and Remoting' section of http://osflash.org/projects   (I've specifically tried the Red5 project - http://osflash.org/red5 - however it didn't run 'out of the box', and also it would need to be heavily customised.)

A commercial solution for this streaming synchronisation is provided by Adobe (http://www.adobe.com/products/flashmediastreaming/) but it's license cost is restrictive to say the least.