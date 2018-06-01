# Magento 2 Testimonial Module
Testimonial module for Magento 2 (CE & EE) that allows to post and get testimonials using web api with correct api credentials.
For current logged in customer we need to use token to post testimonial, since session based is now depreciated 

## Requirements
* [Magento Version 2.2.+](https://github.com/magento/magento2)
* PHP 5.6.x, 7.1.x

## Installation
### Composer
Ensure that the following is added to the main project in composer.json
```json
{
    "require": {
          "ryan/magento2-testimonials": "dev-master"
    }
}
```

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "git@github.com:ryanfern86goa/magento2-testimonials.git"
        }
    ]
}
```
Then run `composer update` to add the module to your composer file

### Magento
To install the module in magento, from the magento root bin folder, 
run `php magento module:enable Ryan_Testimonials`, 
run `php magento setup:upgrade`.

## Instructions
The Web api list can be found at http://magento-root-url/swagger 

List of API's

1) /V1/testimonial/me   Method: POST Permissions: Required : resource:self
2) /V1/testimonial      Method: POST Permissions: Required : resource:Ryan_Testimonials::testimony
3) /V1/testimonial      Method: GET  Permissions: None
4) /V1/testimonial/:id  Method: GET  Permissions: None   


1) /V1/testimonial/me   Method: POST

This is used to post testimony as logged in customer using token

steps 
    1) get token
       example : curl -X POST "http://ryan-magento.loc/rest/V1/integration/customer/token" -H "Content-Type:application/json" -d '{"username": "ryanfernxxx@gmail.com","password": "xxxx"}'
    2) Use the token returned in step 1 call (eg: np1il8igx7sak1dvtv1lsjb5s4q6ut2p)
        curl -X POST "http://ryan-magento.loc/rest/V1/testimonial/me" -H "Content-Type:application/json" -H "Authorization: Bearer np1il8igx7sak1dvtv1lsjb5s4q6ut2p" -d '{"testimony":{"content": "ttt ttt t tt t"}}'

     Payload
     
     ```json
     {
     	"testimony": {
     		"content": "ppp pp  pp  p  pp"
     	}
     }
     ```
     
     OR
     
      ```json
          {
          	"testimony": {
          		"content": "ppp pp  pp  p  pp",
          		"name": "ryanTest1"
          	}
          }
          ```
     
    If name is not provided customer first name will be used
    
    
2) /V1/testimonial      Method: POST

This is used to post testimony for supplied valid customer id

     Payload
     
     ```json
           {
            "testimony": {
                "customer_id": 5,
                "content": "dd ddd dd dd"
            }
           }
     ```
          
          OR
          
     ```json
          {
          	"testimony": {
          		"customer_id": 5,
          		"name": "ryanTest1",
          		"content": "dd ddd dd dd"
          	}
          }
     ```
          
     If name is not provided customer first name will be used   
     

3) /V1/testimonial      Method: GET

   Gets list of testimonies based on criteria provided
   
   Example:
   
   http://ryan-magento.loc/rest/V1/testimonial?searchCriteria[page_size]=6
   
      Payload returned (JSON example)
      
       ```json
                {
                    "items": [
                        {
                            "id": 1,
                            "content": "jrrr rrr r rrr rr rrr",
                            "updated_at": "2018-09-11 13:00:25",
                            "created_at": "2018-06-01 13:00:25",
                            "customer_id": 5
                        },
                        {
                            "id": 2,
                            "content": "bb bbb bbb",
                            "updated_at": "2018-09-11 13:00:25",
                            "created_at": "2018-06-01 13:00:25",
                            "customer_id": 5
                        },
                        {
                            "id": 3,
                            "content": "cc cc ccc",
                            "name": "ryan",
                            "updated_at": "2018-09-11 13:00:25",
                            "created_at": "2018-06-01 13:00:25",
                            "customer_id": 5
                        },
                        {
                            "id": 4,
                            "content": "dd ddd dd dd",
                            "name": "ryanTest1",
                            "updated_at": "2018-09-11 13:00:25",
                            "created_at": "2018-06-01 13:00:25",
                            "customer_id": 5
                        },
                        {
                            "id": 5,
                            "content": "ppp pp  pp  p  pp",
                            "name": "ryan",
                            "updated_at": "2018-09-11 13:00:25",
                            "created_at": "2018-06-01 13:00:25",
                            "customer_id": 43
                        }
                    ],
                    "search_criteria": {
                        "filter_groups": [],
                        "page_size": 6
                    },
                    "total_count": 5
                }
       ```


4) /V1/testimonial:id      Method: GET

   Gets testimony based on testimony entity id
   
   Example:
   
   http://ryan-magento.loc/rest/V1/testimonial/3
   
   Payload returned (JSON example)
   
    ```json
             {
                 "id": 3,
                 "content": "cc cc ccc",
                 "name": "ryan",
                 "updated_at": "2018-09-11 13:00:25",
                 "created_at": "2018-06-01 13:00:25",
                 "customer_id": 5
             }
    ```
   
## License
Copyright © 2016 – 2017 [Ryan Fernandes]
Rights reserved.
