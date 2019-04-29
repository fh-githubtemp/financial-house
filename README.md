# Financial House Reporting Web App
This is the test project that consumes `Reporting API`. You can find the relevant code under `./app/Reporting` and all unit tests are under `./tests`

This project uses latests `Laravel Framework v 5.8.*`.

## How to run the project
Even though project is hosted on `heroku` (https://finance-house.herokuapp.com/), you can run it via `Docker`

Please make sure `Docker` is installed on your machine, and run

### To build the Docker Image (financialhouse)
```bash
cd ./build
./build.sh
```
### To run the project
```bash
cd ./build
./run.sh
```

After the above command, you can visit `http://localhost` on your machine to access to the app.

## Running the unit tests
To run the unit tests, 
```bash
cd ./build
./test.sh
```
