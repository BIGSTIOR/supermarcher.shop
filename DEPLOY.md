# Déploiement de Supermarché

Ce projet est prêt pour un déploiement sur un VPS Linux avec PHP 8.3, Composer, NPM, MySQL et Nginx.

## 1) Préparer le serveur

Exécuter sur la machine cible :

```bash
sudo apt update
sudo apt install -y nginx mysql-server php8.3 php8.3-cli php8.3-mbstring php8.3-bcmath php8.3-pdo php8.3-mysql php8.3-xml php8.3-zip php8.3-gd php8.3-intl php8.3-curl php8.3-redis composer nodejs npm unzip git
sudo mysql -u root -e "CREATE DATABASE IF NOT EXISTS supermarche;"
sudo mkdir -p /var/www/supermarche
sudo chown -R $USER:$USER /var/www/supermarche
```

## 2) Configurer le dépôt GitHub

Créer un dépôt GitHub public ou privé et pousser le code :

```bash
git remote set-url origin https://github.com/BIGSTIOR/supermarcher.shop.git
git push origin main
```

## 3) Ajouter les secrets GitHub Actions

Dans GitHub > Settings > Secrets and variables > Actions, ajouter :

- `DEPLOY_HOST` : adresse IP ou nom de domaine du serveur
- `DEPLOY_USER` : utilisateur SSH (par exemple `deploy`)
- `DEPLOY_KEY` : clé privée SSH
- `DEPLOY_PORT` : 22 (facultatif)

## 4) Configurer le serveur pour recevoir le code

Créer un utilisateur SSH avec accès au dossier web :

```bash
sudo adduser deploy
sudo usermod -aG sudo deploy
sudo mkdir -p /var/www/supermarche
sudo chown -R deploy:www-data /var/www/supermarche
```

Ensuite, créer une clé SSH sur la machine locale et l’ajouter dans le dossier `~/.ssh/authorized_keys` du serveur.

## 5) Configurer l’environnement de production

Dans `/var/www/supermarche/.env`, ajouter :

```env
APP_NAME="Supermarché"
APP_ENV=production
APP_KEY=base64:GENERER_UNE_CLE_ICI
APP_DEBUG=false
APP_URL=https://votre-domaine.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=supermarche
DB_USERNAME=root
DB_PASSWORD=VotreMotDePasse

CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync
MAIL_MAILER=log
```

Puis générer la clé Laravel :

```bash
php artisan key:generate --force
php artisan storage:link
php artisan migrate --force
```

## 6) Configurer Nginx

Exemple de configuration :

```nginx
server {
    listen 80;
    server_name votre-domaine.com;
    root /var/www/supermarche/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/run/php/php8.3-fpm.sock;
    }
}
```

Activer le site :

```bash
sudo ln -s /etc/nginx/sites-available/supermarche /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

## 7) GitHub Actions

Chaque push sur `main` déclenche le workflow `.github/workflows/deploy.yml` et :

- installe les dépendances PHP et Node,
- construit le front,
- exécute les tests,
- déploie le code par SSH,
- exécute les migrations et la mise en cache.

## 8) Déploiement manuel

Vous pouvez aussi lancer le script localement sur le serveur :

```bash
bash /var/www/supermarche/scripts/deploy.sh
```

## 9) Vérification

Tester l’application :

```bash
curl -I https://votre-domaine.com
```

Ou vérifier le site localement :

```bash
php artisan serve --host 0.0.0.0 --port 8000
```
