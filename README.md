
# Comments app

Small web app with comment section

Js, Vue3, PHP8, Slim framework, MySQL


## API Reference

#### Get all comments

```http
  GET /comments/all
```

#### Add comment

```http
  POST /comments/add
```
Body reference
```json
{
   "Comment_username" : "postedUser135",
   "Comment_content" : "contentcontent"
}
```

#### Delete comment

```http
  DELETE /comments/delete/{id}
```

| Parameter | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `id`      | `number` | **Required**. Id of comment to delete |

#### Captcha token verifying

```http
  POST /captcha/verify'
```
Body
```json
{
   captcha: token
}
```
