# Welcome to GAME.SCOPE 🎮

![GAME.SCOPE TEMPLATE](assets/images/game.scope-project.png)

GAME.SCOPE is a blog dedicated to the gaming community, designed for passionate gamers. Our goal is to create a platform where players can share their knowledge, discoveries, and passions for games. This README will guide you through the steps to find our blog online and set up a local development environment to contribute or explore our source code.


## Setting Up a Development Environment

If you want to contribute to the development of GAME.SCOPE or simply explore our source code, here's how to set up a local development environment:

### Prerequisites

- PHP 7.4 or higher
- Composer
- Symfony CLI
- MySQL or another database of your choice

### Steps to configure your local environment

1. Clone this GitHub repository to your machine:
   ```bash
   git clone https://github.com/yourusername/gamescope.git
   
   ```

2. Navigate to the project directory:
   ```bash
   cd gamescope
   ```
3. Install PHP dependencies using Composer:
     ```bash
   composer install
   ```
4. Configure your database by modifying the .env file with your connection details.

5. Create the database and run migrations:
 ```bash
 php bin/console doctrine:database:create
```
```bash
 php bin/console doctrine:migrations:migrate
```
6. Start the Symfony server:

   ```bash
   symfony server:start
   ```
###License

This project is under the MIT license. Please refer to the LICENSE file for more information.

## If you like it, do fork 🍴 and star ⭐
