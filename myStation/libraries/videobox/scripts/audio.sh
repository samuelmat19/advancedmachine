(test -f "$2.mp3"  || test -f "$2.mp3__"  || (avconv -loglevel quiet -i "$1"             -f mp3   -y "$2.mp3__"  && mv "$2.mp3__"  "$2.mp3"))  || rm "$2.mp3__"  &
(test -f "$2.webm" || test -f "$2.webm__" || (avconv -loglevel quiet -i "$1"             -f webm  -y "$2.webm__" && mv "$2.webm__" "$2.webm")) || rm "$2.webm__" &
(test -f "$2.oga"  || test -f "$2.oga__"  || (avconv -loglevel quiet -i "$1" -q:a 5      -f ogg   -y "$2.oga__"  && mv "$2.oga__"  "$2.oga"))  || rm "$2.oga__"  &
(test -f "$2.wav"  || test -f "$2.wav__"  || (avconv -loglevel quiet -i "$1" -c:a pcm_u8 -f wav   -y "$2.wav__"  && mv "$2.wav__"  "$2.wav"))  || rm "$2.wav__"  &