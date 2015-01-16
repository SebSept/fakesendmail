# fakesendmail

## What ?

This package/phar is a sendmail replacement. 
**It does not send email**, it stores them so that you can perform debugging or testing.
(stored on `/tmp/lastmail` in json)

## Why ?

Was trying to test email sending (using a functionnal testing framework) : did my app sent a mail ? to the expected person, with the expected content ?
I tried mailcatch (a ruby app), looks really great, but I've not seen anything else than ruby errors.
I don't like ruby (because I don't know it probably, blame me if you want), I focuse on php.
I've started this mailcatch replacement.

## How ?

You have to replace system sendmail app in php configuration with the one provided here.

When a php script send a mail using `mail()` function, the mail is not sent, it is written in  `/tmp/lastmail`.
( Stmp mails sent form you machine will continue to be sent, it changes only mail() behavior.)

## Installation

### Phar

- download the [fakesendmail.phar](https://github.com/SebSept/fakesendmail/blob/wip/fakesendmail.phar?raw=true)
- put it anywhere where php can execute it
- make it executable `chmod a+x fakesendmail.phar` for example.
- update `php.ini` to use `fakesendmail.phar`. it may look like this :

```ini
...
[mail function]
sendmail_path = /usr/local/bin/fakesendmail.phar
...
```

You may need to restart apache `sudo apachectl restart` (maybe not needed).

# Disclaimer

Very early development stage : this is for local development use.
I may not touch this anymore, since it does what I want it to do for the moment.

Discuss, ask, fork ;) 

