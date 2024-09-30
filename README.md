
# Comments app

Small web app with comment section

Js, Vue3, PHP8, Slim framework, MySQL

## MySQL Database setup

```SQL
  CREATE DATABASE `Comments`

  CREATE TABLE `Comments` (
  `Comment_Id` int NOT NULL AUTO_INCREMENT,
  `Comment_username` varchar(100) NOT NULL,
  `Comment_content` varchar(2000) NOT NULL,
  `Comment_datetime` datetime NOT NULL,
  PRIMARY KEY (`Comment_Id`)
```

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
  POST /captcha/verify
```
Body
```json
{
   captcha: token
}
```


