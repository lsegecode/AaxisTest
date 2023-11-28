# AaxisTest Symfony Project

Welcome to the AaxisTest Symfony project! Follow these steps to get started.

## Prerequisites

Make sure you have the following installed:

- [Docker](https://www.docker.com/)
- [Composer](https://getcomposer.org/)

## Getting Started

1. **Clone the Repository:**
   ```bash
   git clone https://github.com/your-username/aaxistest-symfony.git
   cd aaxistest-symfony

2. **Start the Docker Containers:**
make start

3. **Install Dependencies:**
composer install

4. **Set Up SSH for Docker:**
make ssh-be

5. **Serve the symfony Application:**
symfony serve


Now, your Symfony application should be up and running. Access it in your browser at http://127.0.0.1:1000/index.php/product/list


# Interact with the API with Postman
---

Open Postman:
If you don't have Postman installed, download and install it from https://www.postman.com/.

GET Endpoint:

URL: http://127.0.0.1:1000/index.php/product/list
Method: GET
Headers: (No specific headers needed for this endpoint)
POST Endpoint:

URL: http://127.0.0.1:1000/index.php/product/load
Method: POST
Headers:
Content-Type: application/json
Body (raw JSON):
json
Copy code
[
  {
    "sku": "ABC123",
    "product_name": "Example Product",
    "description": "This is a test product"
  },
  {
    "sku": "XYZ789",
    "product_name": "Another Product",
    "description": "Another test product"
  }
]
PUT Endpoint:

URL: http://127.0.0.1:1000/index.php/product/update
Method: PUT
Headers:
Content-Type: application/json
Body (raw JSON):
json
Copy code
[
    {
        "sku": "ABC123",
        "product_name": "Updated Product",
        "description": "Updated product description"
    }
]
Make sure your Symfony application is running (symfony serve) and Docker containers are up and running. Adjust the URLs accordingly if your setup uses a different host or port.