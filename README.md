# MadGPT Project

## Overview
MadGPT is a web-based AI application that debunks myths about single-GPU passthrough setups. The project is aimed at handling the common misconceptions and queries related to this topic, and reduces the support burden by providing playful and informative responses to user-submitted scenarios. 

## Structure

The project structure is as follows:
```
.
└── public
    ├── backend.php
    ├── cgi-bin
    ├── config.php
    ├── config.sample.php
    ├── DB.php
    ├── index.html
    ├── logo1.png
    ├── logo2.png
    ├── logo3.png
    ├── logo4.png
    ├── OpenAIAPI.php
    └── prompt.php
```
Each file is responsible for a specific function in the project:

- `backend.php` is the backend entry point. It handles server-side logic, communicates with the OpenAI API, and manages database operations.
- `config.php` contains configuration data for the project, such as database credentials and the OpenAI API key.
- `DB.php` is a helper file containing functions to interact with the database.
- `index.html` is the main webpage that users interact with. It contains the frontend design and client-side logic.
- `OpenAIAPI.php` is a helper file containing functions to interact with the OpenAI API.
- `prompt.php` is a configuration file which outlines the model's behavior and supplies the prompts to be used by the AI model.

The `logo1.png`, `logo2.png`, `logo3.png`, and `logo4.png` files are the different logos displayed on the website.

## Usage

To use this project:

1. Clone the repository to your local machine or server.
2. Rename `config.sample.php` to `config.php`.
3. Update `config.php` with your actual database and OpenAI API key.
4. Navigate to the root directory in your web server and you should be able to access the application in your web browser.

## Contributing

As this project is personal, I am currently not accepting contributions. If you have feedback or suggestions, feel free to reach out.

## Contact

For more information or queries, please contact me at `<your-email>`.

## License

This project is licensed under the `<license-name>` License - see the `<license-file>` file for details.

(Actual readme: [README-human.md](README-human.md))
