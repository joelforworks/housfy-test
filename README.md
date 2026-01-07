
## Housfy test

I tried using the technology stack that Paula mentioned in the interview: Vue + Laravel.

The app is based on choosing a vehicle and sending commands to move it.

### How to run the project
Edit .env 

```
DB_DATABASE=your_db
DB_USERNAME=your_user
DB_PASSWORD=your_password
```

Commands
```
composer install
npm install
php artisan migrate
php artisan db:seed
php artisan serve
npm run dev
```

### Resume

#### Schema ER

<img width="643" height="573" alt="image" src="https://github.com/user-attachments/assets/54a84ae9-5d8a-4b8e-9650-ed2b6a9023d9" />


#### Routes

wep routes
| Route | Info |
| -------- | ------- |
| GET / | Show the main page where the app works |

api routes

| Route | Info |
| -------- | ------- |
| POST /logs/send | Manage the command for move and register the logs |
| GET /logs/{vehicle} | Show all logs from vehicle |
| GET /logs/generate-obstacles/{planet} | Generate obstacle for determinate planet |

#### Components and Pages

<img width="265" height="96" alt="image" src="https://github.com/user-attachments/assets/f41f74c2-8781-426c-9aeb-ba158f17afd8" />

LogHistory -> display the vehicle logs.

PlanetMap -> display the the planet with obstacles and the vehicle.

Home -> The only page on the app.

#### Api manage
<img width="419" height="646" alt="image" src="https://github.com/user-attachments/assets/2bae20bd-5742-4c92-9078-f32c798f01b7" />

In this way i only need to implement new methods on the service class for new requests.




