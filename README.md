### Command


The command imports data from the Url endpoint

~~~
php yii parse
~~~

### Endpoints

Get countries

~~~
GET http://localhost/country
~~~

Get cities

~~~
GET http://localhost/city
~~~

Get directions

~~~
GET http://localhost/destination
~~~

Get all 3 data combined (Cities, countries, directions)

~~~
GET http://localhost/all-results
~~~

Store a new direction

~~~
POST http://localhost/destination/store
~~~

Payload:

~~~
{
	"price": 2000,
	"cur": "тг",
	"cityPki": 9,
	"countryPki": 5,
	"days": [5,6,7,8],
	"defaultDate": [1,2,3,6,5]
}
~~~
