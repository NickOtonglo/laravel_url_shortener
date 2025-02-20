# URL Shortener

This is a simple URL shortener application built with Laravel. It allows users to shorten long URLs and retrieve the original URLs using the shortened links.

## Features

- Shorten long URLs
- Retrieve original URLs from shortened links
- Simple and user-friendly interface
- Has 'encode' and 'decode' endpoints for API use

## Installation

1. Clone the repository:
    ```sh
    git clone https://github.com/NickOtonglo/laravel_url_shortener.git
    ```

2. Navigate to the project directory:
    ```sh
    cd laravel-url-shortener
    ```

3. Install the dependencies:
    ```sh
    composer install
    ```

4. Copy the `.env.example` file to `.env` and update the environment variables:
    ```sh
    cp .env.example .env
    ```

5. Generate the application key:
    ```sh
    php artisan key:generate
    ```

6. Run the database migrations:
    ```sh
    php artisan migrate
    ```

7. Start the development server:
    ```sh
    php artisan serve
    ```

## Usage

1. Open your browser and navigate to `http://localhost`.
2. Enter a long URL in the input field and click the "Shorten" button.
3. The shortened URL will be displayed below the input field.
4. To retrieve the original URL, enter the shortened URL in the second input field and click the "Retrieve" button.
5. The original URL will be displayed below the input field.

## Running Tests

To run the tests, use the command:
```sh
php artisan test
```

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.
