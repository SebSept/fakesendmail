# fakesendmail

## What ?

This package/phar is a sendmail replacement. 
**It does not send email**, it stores them so that you can perform debugging or testing.
(stored on `/tmp/lastmail` in json)

## Why ?

Was trying to test email sending (using a functionnal testing framework) : did my app sent a mail ? to the expected person, with the expected content ?
I tried mailcatch (a ruby app), looks really great, but I've not seen anything else than ruby errors.
I don't like ruby (because I don't know it probably, blame me if you want), I focus on php.
I've started this mailcatch replacement.

## How ?

You have to replace system sendmail app in php configuration with the one provided here.

When a php script send a mail using `mail()` function, the mail is not sent, it is written in  `/tmp/lastmail`.
( Stmp mails sent form you machine will continue to be sent, it changes only mail() behavior.)

## Installation

### Phar

- download the [fakesendmail.phar](https://github.com/SebSept/fakesendmail/blob/wip/fakesendmail.phar?raw=true)
- put it where php can execute it
- make it executable `chmod a+x fakesendmail.phar` (for example).
- update `php.ini` to use `fakesendmail.phar` so it may look like this :

```ini
...
[mail function]
sendmail_path = /usr/local/bin/fakesendmail.phar
...
```

You may need to restart apache `sudo apachectl restart` (maybe not needed).


## Usage

Use php to send a mail (or any class that can use it, as SwiftMailer or PhpMailer).

```php
mail ( 'seb@example.com' , 'my test mail' , 'here is the txt content.' );
```

Then you have a new file in your temporary dir with mail content. On linux, it could be '/tmp/lastmail' . 
The content is in json.

For example : 

```json
{
	"date":"Wed, 30 Jan 2013 16:18:32 -0600",
	"to":[{"name":"",	"address":"atapi@astrotraker.com"}],
	"cc":[],
	"bcc":[{"name":"","address":"someone-in-bcc@somewhere.com"},{"name":"justin nainconnu","address":"someoneelse-in-bcc@somewhere.com"}],
	"from":{"name":"Michael Smith","address":"example@example.com"},
	"subject":"Fwd: test subject",
	"html_body":"<html>...<\/html>",
	"text_body":"\n\n--\n\nThanks,\nMichael\n"
}
```

You can now easily perform unit tests after getting content : 

```php
$tested_mail = json_decode( file_get_contents('/tmp/lastmail') );

// you can now access a simple pretty StdClass
$tested_mail->date; // (string) "Wed, 30 Jan 2013 16:18:32 -0600"
$tested_mail->to; // array
$tested_mail->to[0]->address; // (string) "atapi@astrotraker.com"

```

No mail was really sent.

## Configuration

The only option is the output file :

```sh
fakesendmail.phar --output /home/jack/dev/myproject/tests/lastsentmail.json
```

So json will we written in /home/jack/dev/myproject/tests/lastsentmail.json

An exception will be thrown if php fails to write to the file (SebSept\FakeSendmail\FileWriterException)


# Disclaimer

Very early development stage : this is for local development use.
I may not touch this anymore, since it does what I want it to do for the moment.

Discuss, ask, fork ;) 

