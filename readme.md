# EWATUS Tips API

## Endpoints

Developers requiring access to the water tips API will be provided with a key they can use to retrieve and manage water tips and their categories.  
There are two levels of access to the system, basic and full. Full level access provides complete access to all endpoints (users, categories, tips) while the basic only allows creation of tips as well as editting and removing of tips that have been created by the same developer id. Authorization will be done via the `Authorization` HTTP header with the `Secret ` prefix. eg `Authorization: Secret DEV-SECRET-KEY`.

*Notice:* __All endpoints require authentication.__  
Endpoints requiring specific access levels will be noted as such.  
*Notice:* __Tip and Category GET endpoints return all the possible languages a tip or category is stored in.__  
Developers can request a single language by providing the locale `subtag` for the language they want returned. The `GET /locales` endpoint provides a list of the possible languages that can be stored and retrieved on the API.  
*Warning:* __Due to the fact that the API only provides a secret key for developers to use, the API's usage is prohibited from client-slide applications (eg. Javascript).__
If this functionality is required a JSON Web Token based authentication flow will be provided where developer will be able to create short and long lived tokens with read only access which they will be able to use on their client-side applications.  

### GET /locales

Returns a list of all the available and allowed language the API supports.  
The languages are according to the official [IANA Subtag Language Registry](http://www.iana.org/assignments/language-subtag-registry/language-subtag-registry).

*Notice:* __The number of locales in the database can be retrieved from the `X-Total-Count` header of the response.__

```json
[{
  "id": 1,
	"subtag": "en",
	"description": "English"
},{
  "id": 2,
	"subtag": "el",
	"description": "Greek"
}]
```

### POST /locales

Inserts a new available and allows language.  
The language must conform with the [IANA Subtag Language Registry](http://www.iana.org/assignments/language-subtag-registry/language-subtag-registry).  
The subtag must be unique.

*Notice:* __Requires admin level authentication.__

Returns: __Status 201, 400.__

```json
[{
	"subtag": "jp",
	"description": "Japanese"
}]
```

### PUT /locales/{subtag}

Modifies an existing language based on its subtag field.  
The subtag must conform with the [IANA Subtag Language Registry](http://www.iana.org/assignments/language-subtag-registry/language-subtag-registry).  

*Notice:* __Requires admin level authentication.__

Returns: __Status 200, 400.__

```json
[{
	"subtag": "jp",
	"description": "Japanese"
}]
```

### DELETE /locales/{subtag}

Removes an existing language based on its subtag field.  

*Notice:* __Requires admin level authentication.__  
*Warning:* __This action will remove ALL localizations of tips and categories of this language.__  

Returns: __Status 200.__

### GET /categories

Returns a list of all categories.  
Categories can have an infinite level of nested sub-categories by defining their `parent_id` field.  
By default the categories will be returned as a single level list. An optional query URL parameter of `?nested=true` can be added to return the categories in a nested form.  

*Notice:* __Optionally accepts the `locale` URL parameter to request a single translation.__  
*Notice:* __Each category includes a read-only field that denotes the number of tips that are directly related to this category (`tips_count`).__ This will __not__ calculate the number of tips related to child categories.  
*Notice:* __The number of categories in the database can be retrieved from the `X-Total-Count` header of the response.__

Returns: __Status 200.__

```json
[{
	"id": 1,
	"parent_id": null,
	"title": {
		"en": "Tips used by the two DSS WPs",
		"el": "Συμβουλές που χρησιμοποιούνται στα 2 WP που κάνουν DSS"
	},
	"description": {
		"en": "Tips used mainly by the DSS system",
		"el": "Συμβουλές που χρησιμοποιεί το DSS"
	},
	"tips_count": 1
},{
	"id": 2,
	"parent_id": 2,
	"title": {
		"en": "Tips used for two household DSS WP",
		"el": "Συμβουλές για το οικιακό DSS σύστημα"
	},
	"description": {
		"en": "Tips used for two household DSS WP - Description",
		"el": "Συμβουλές για το οικιακό DSS σύστημα - Περιγραφή"
	},
	"tips_count": 3
}]
```

Using the optional `?nested=true` URL parameter.

```json
[{
	"id": 1,
	"parent_id": null,
	"title": {
		"en": "Tips used by the two DSS WPs",
		"el": "Συμβουλές για το οικιακό DSS σύστημα"
	},
	"description": {
		"en": "Tips used by the two DSS WPs - Description",
		"el": "Συμβουλές που χρησιμοποιούνται στα 2 WP που κάνουν DSS - Περιγραφή"
	},
	"tips_count": 2,
	"children": [{
		"id": 2,
		"parent_id": 1,
		"title": {
			"en": "Tips used for two household DSS WP",
			"el": "Συμβουλές για το οικιακό DSS σύστημα"
		},
		"description": {
			"en": "Tips used for two household DSS WP - Description",
			"el": "Συμβουλές για το οικιακό DSS σύστημα - Περιγραφή"
		},
		"tips_count": 3
	}]
}]
```

A single language can be retrieved by providing the optional `?locale=el` URL parameter. e.g. for `el`.

```json
[{
	"id": 1,
	"parent_id": null,
	"title": "Συμβουλές που χρησιμοποιούνται στα 2 WP που κάνουν DSS",
	"description": "Συμβουλές που χρησιμοποιούνται στα 2 WP που κάνουν DSS - Περιγραφή",
	"tips_count": 2
},{
	"id": 2,
	"parent_id": 1,
	"title": "Συμβουλές για το οικιακό DSS σύστημα",
	"description": "Συμβουλές για το οικιακό DSS σύστημα - Περιγραφή",
	"tips_count": 3
}]
```

### GET /categories/{category_id}

Returns a a single categories.  
Categories can have an infinite level of nested sub-categories by defining their `parent_id` field.  
By default the categories will be returned as a single level list. An optional query URL parameter of `?nested=true` can be added to return the categories in a nested form.

*Notice:* __Optionally accepts the `locale` URL parameter to request a single translation.__

Returns: __Status 200.__

```json
{
	"id": 1,
	"parent_id": null,
	"title": {
		"en": "Tips used by the two DSS WPs",
		"el": "Συμβουλές που χρησιμοποιούνται στα 2 WP που κάνουν DSS"
	},
	"description": {
		"en": "Tips used by the two DSS WPs - Description",
		"el": "Συμβουλές που χρησιμοποιούνται στα 2 WP που κάνουν DSS - Περιγραφή"
	},
	"tips_count": 3
}
```

### POST /categories

Create a new category.  
Categories can be only added in their full form with all the available languages.

*Notice: __Category `id` field is not required and will be automatically assigned a value by the API.__

Returns: __Status 201, 400.__

```json
{
	"parent_id": 1,
	"title": {
		"en": "Tips used by the two DSS WPs",
		"el": "Συμβουλές που χρησιμοποιούνται στα 2 WP που κάνουν DSS"
	},
	"description": {
		"en": "Tips used by the two DSS WPs - Description",
		"el": "Συμβουλές που χρησιμοποιούνται στα 2 WP που κάνουν DSS - Περιγραφή"
	}
}
```

### PUT /categories/{category_id}

Modify (replace) an existing category by its id.  
Using the `PUT` HTTP method, the complete category object must be provided with all its translations.

*Notice:* __Only the developer that created can update a category, or a developer with admin privileges.__

Returns: __Status 200, 400.__

```json
{
	"id": 3,
	"parent_id": 1,
	"title": {
		"en": "Tips used by the two DSS WPs",
		"el": "Δοκιμαστική κατηγορία"
	},
	"description": {
		"en": "Tips used by the two DSS WPs - Description",
		"el": "Συμβουλές που χρησιμοποιούνται στα 2 WP που κάνουν DSS - Περιγραφή"
	}
}
```

### DELETE /categories/{category_id}

Remove an existing category by its id.  
Trying to remove a category that children categories or tips referencing to it will result in a

*Notice:* __Only the developer that created can update a category, or a developer with admin privileges.__

Returns: __Status 200, 400.__

### GET /tips

Returns a list of all tips.  
Each tip must belong to a single category. Tips can be filtered by `category_id` using the optional URL query parameter `?category_id={category_id}`.  
A random tip can be retrieved by using the URL query parameters `random=true` in conjunction with the additional optional parameters `limit={limit}` and `category_id={category_id}`. e.g. `?random=true&category_id=1&limit=2` which will return 2 random tips from the category with id 2. *To maintain consistency the JSON returned will __always__ be an array, even if returning a single tip.*

*Notice:* __Optionally accepts the `locale` URL paramenter to request a single translation.__
*Notice:* __The number of tips in the database can be retrieved from the `X-Total-Count` header of the response.__

Returns: __Status 200.__

```json
[{
	"id": 1,
	"category_id": 1,
	"title": {
		"en": "Reuse old water",
		"el": "Χρησιμοποιήστε το παλιό νερό"
	},
	"description": {
		"en": "Throw the water left in your cup on an indoor plant or on the garden instead throw it in the sink.",
		"el": "Χρησιμοποιήστε το νερό που έχει μείνει στο ποτήρι σας για να ποτήσετε κάποιο γλαστράκι ή τον κήπο σας, από το να το αδειάσετε στον νεροχύτη"
	},
  "framing": "gain"
},{
	"id": 2,
	"category_id": 2,
	"title": {
		"en": "Use bowls to wash vegies.",
		"el": "Χρησιμοποιείτε μπολ για το πλύσιμο των φρούτων"
	},
	"description": {
		"en": "Prefer to wash fruits, greens and vegetables in a bowl of water instead of down constantly open tap. A tap running spends about 4 litres per minute.",
		"el": "Χρησιμοποιήστε μπολ για να πλύνετε τα φρούτα και τα λαχανικά. Θα σας γλιτώσει αρκετό νερό"
	},
  "framing": "gain"
}]
```

Using the optional `?category_id=1` URL parameter.

```json
[{
	"id": 1,
	"category_id": 1,
	"title": {
		"en": "Use bowls to wash vegies",
		"el": "Χρησιμοποιείτε μπολ για το πλύσιμο των φρούτων"
	},
	"description": {
		"en": "Throw the water left in your cup on an indoor plant or on the garden instead throw it in the sink.",
		"el": "Χρησιμοποιήστε το νερό που έχει μείνει στο ποτήρι σας για να ποτήσετε κάποιο γλαστράκι ή τον κήπο σας, από το να το αδειάσετε στον νεροχύτη"
	},
  "framing": "gain"
}]
```

A single language can be retrieved by providing the optional `?locale=el`. e.g. for `el`.

```json
[{
	"id": 1,
	"category_id": 1,
	"title": "Χρησιμοποιήστε το παλιό νερό",
	"description": "Χρησιμοποιήστε το νερό που έχει μείνει στο ποτήρι σας για να ποτήσετε κάποιο γλαστράκι ή τον κήπο σας, από το να το αδειάσετε στον νεροχύτη",
  "framing": "gain"
},{
	"id": 2,
	"category_id": 2,
	"title": "Χρησιμοποιείτε μπολ για το πλύσιμο των φρούτων",
	"description": "Χρησιμοποιήστε μπολ για να πλύνετε τα φρούτα και τα λαχανικά. Θα σας γλιτώσει αρκετό νερό",
  "framing": "gain"
}]
```

### GET /tips/{tip_id}

Returns a a single tip.  

*Notice:* __Optionally accepts the `locale` URL parameter to request a single translation.__

Returns: __Status 200.__

```json
{
	"id": 1,
	"category_id": null,
	"title": {
		"en": "Use bowls to wash vegies",
		"el": "Χρησιμοποιείτε μπολ για το πλύσιμο των φρούτων"
	},
	"description": {
		"en": "Throw the water left in your cup on an indoor plant or on the garden instead throw it in the sink. 2",
		"el": "Throw the water left in your cup on an indoor plant or on the garden instead throw it in the sink. 2"
	},
  "framing": "gain"
}
```

### POST /tips

Create a new tip.  
Tips can be only added in their full form with all the available languages.

*Notice: __Tip `id` field is not required and will be automatically assigned a value by the API.__

Returns: __Status 201, 400.__

```json
{
	"category_id": 1,
	"title": {
		"en": "Use bowls to wash vegies 3",
		"el": "Χρησιμοποιείτε μπολ για το πλύσιμο των φρούτων 3"
	},
	"description": {
		"en": "Throw the water left in your cup on an indoor plant or on the garden instead throw it in the sink. 3",
		"el": "Χρησιμοποιήστε το νερό που έχει μείνει στο ποτήρι σας για να ποτήσετε κάποιο γλαστράκι ή τον κήπο σας, από το να το αδειάσετε στον νεροχύτη. 3"
	},
  "framing": "gain"
}
```

### PUT /tips/{tip_id}

Modify (replace) an existing tip by its id.  
Using the `PUT` HTTP method, the complete tip object must be provided with all its translations.

*Notice:* __Only the developer that created can update a tip, or a developer with admin privileges.__  

Returns: __Status 200, 400.__

```json
{
	"id": 3,
	"category_id": 1,
	"title": {
		"en": "Use bowls to wash vegies",
		"el": "Χρησιμοποιείτε μπολ για το πλύσιμο των φρούτων"
	},
	"description": {
		"en": "Throw the water left in your cup on an indoor plant or on the garden instead throw it in the sink.",
		"el": "Χρησιμοποιήστε το νερό που έχει μείνει στο ποτήρι σας για να ποτήσετε κάποιο γλαστράκι ή τον κήπο σας, από το να το αδειάσετε στον νεροχύτη"
	},
  "framing": "gain"
}
```

### DELETE /tips/{tip_id}

Remove an existing tip by its id.  
Trying to remove a tip that children tips or tips referencing to it will result in a

*Notice:* __Only the developer that created can update a tip, or a developer with admin privileges.__

Returns: __Status 200, 400.__
