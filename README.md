# PNC Blog API
This API serves as the backend for the PNC blog site. It provides various endpoints to interact with the database and perform actions such as user authentication, manage users, posting and managing blog posts, follow-unfollow feature, and more. This README will guide you through setting up and using the API with your frontend.

## 📖 Table of Contents
- [Requirements](#📘-requirements)
- [Getting Started](#🔧-getting-started)
- [Running the Server](#⚡-running-the-server)

## 📘 Requirements
Make sure you have installed the following:
- [Visual Studio Code](https://code.visualstudio.com/download)
- [XAMPP](https://www.apachefriends.org/download.html)
- [Composer](https://getcomposer.org/download/)
- [Git](https://git-scm.com/downloads)
- [GitHub Desktop *(Optional)*](https://desktop.github.com/)

## 🔧 Getting Started
### Starting XAMPP Server
1. Open XAMPP Control Panel
2. Start *Apache* & *MySQL* servers
3. Clone the repository with [CLI](#cloning-repository-with-cli) or [GitHub Desktop](#cloning-repository-with-github-desktop)

<br>

### Cloning Repository with CLI
1. Open Visual Studio Code
2. Choose a folder where you want to clone the repository in *File > Open Folder*
3. Open Visual Studio Code terminal *(Ctrl + `)* and enter the following commands:

Clone the repository
```
git clone https://github.com/burnjoe/pnc-blog-api.git
```

Change terminal directory
```
cd pnc-blog-api
```

<br>

### Cloning Repository with GitHub Desktop
1. Open GitHub Desktop
2. Clone the repository in *File > Clone Repository*

Select URL tab and paste the following:
```
https://github.com/burnjoe/pnc-blog-api.git
```

3. Choose a folder where you want to clone the repository and then *Clone*
4. Open the cloned repository in Visual Studio Code in *Repository > Open in Visual Studio Code*

<br>

### Adding All Dependencies and Setting Up the Project

#### Open Visual Studio Code terminal *(Ctrl + `)* and enter the following commands:

Install composer to the project
```
composer install
```

Install npm to the project
```
npm install
```

Create .env 
```
copy .env.example .env
```

Generate new app key
```
php artisan key:generate
```

Run the migration
```
php artisan migrate
```

When prompted to create the database, type `yes`
```
Would you like to create it? (yes/no) [no]
> yes
```

Run the seeder
```
php artisan db:seed
```

Generate encryption key to generate secure access tokens. [See Laravel Passport](https://laravel.com/docs/10.x/passport#installation).
```
php artisan passport:install
```

When prompted to run pending database migration, type `yes`
```
Would you like to run all pending database migrations? (yes/no) [yes]:
> yes
```

When prompted to create clients, type `yes`
```
Would you like to create the "personal access" and "password grant" clients? (yes/no) [yes]:
> yes
```

After installing passport, copy the generated `Client ID` and `Client Secret` to the newly created variables in `.env` file
```dotenv
PASSPORT_PERSONAL_ACCESS_CLIENT_ID = "1"
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET = "Hl0rRWjgKact31fjZupAMK0E7HwksWN2MhrznmL8"
```


## ⚡ Running the Server

#### Enter these following commands to your terminal:

Start local development server for your laravel app
```
php artisan serve
```


### ✨ You can now test API endpoints with http://localhost:8000/api/{endpoint}