Implement a search feature that allows users to search for products by name or description.
> Implemented in /product view  
> From the ProductController under index() method, I added a scope called "filterResult" where the logic can be found in Product Model under scopeFilterResult() method

Implement pagination for product and order listings.
 > Implemented in /product and /order view  
 > I basically call the paginate() from respective method upon calling the result, below are the sample codes I used
    > Product::filterResult(request(['name']))->paginate(10);
    > $orders = Order::with(['user'])->orderBy('created_at','DESC')->paginate(10)

Use Laravel's caching system to improve performance.
 > Implemented in /product search
 > I utilized the most frequently used part of the system, which is the product search functionality, and extracted the inputted word from the search field to maximize its usage. Here's a sample code snippet:
    >  Cache::remember($requestKey, 10, function () { . . . }

Include any necessary SQL schema and migration files in your repository.
    > Basic configuration is needed
        > run "composer update" or "composer install"
        > copy ".env.example" as ".env", and change necessary setting if needed
        > Please create a database based on the "DB_DATABASE", or you can path your own existing DB
        > run migration and seeder

After migration here are the default users can be used:
    > Admin:
        > UN: admin@gmail.com
        > PW: password

    > Non-Admin
        > UN: normal@gmail.com
        > PW: password