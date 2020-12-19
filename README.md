# Hotel Booking REST APIs

This project is built with Lumen framework for **CodeMasters Hackathon 2020**

## Setup

- Clone this repo
- Run `composer install` to install project dependencies
- Copy `.env.example` file to `.env`
- Env defaults should be enough to run the project, if php `sqlite` module is loaded. Otherwise, **mysql** can also be configured by editing `DB_` variables in `.env` file.

## API Documentation

**Postman** was used during project development & for api documentation.
Docs can be found [here](https://documenter.getpostman.com/view/2647754/TVssk8mf) . 
**OpenAPI** collection is added in the project files as `OpenApi.yml`

## Testing

**PHPUnit** tests are written to test most of the api endpoints. Tests can be run by invoking `phpunit` or `./vendor/bin/phpunit` command.

## License

The Lumen framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
