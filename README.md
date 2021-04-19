# Telegram Channel Listener (MadelineProto)
Copy new posts from defined channels to another channel (MadelineProto)

* Install
1. Install php7.4+ & extensions:
```
sudo apt-get install python-software-properties software-properties-common screen
sudo LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install php7.4 php7.4-dev php7.4-xml php7.4-zip php7.4-gmp php7.4-cli php7.4-mbstring php7.4-json git -y
```
2. Edit `config.php` file & set sudo id, source channel id, and target channel id.
3. Permit launch.sh file by `chmod +x launch.sh`
4. `./launch.sh` to launch bot, and login for first time.
5. You can use `screen ./launch.sh` to launch bot & deattach terminal by `CTRL + SHIFT + D`
