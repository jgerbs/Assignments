# COMP 3015 News

An article aggregrator.

## Running the application

Ensure an `articles.json` file is at the server root.

Run:

```
php -S localhost:9000 # or you could use a different port
```

Install Node (dev) dependencies:

```
npm i
```

Run the Node server for reloading CSS changes:

```
npm run dev
```

You can also run this using Apache or Nginx.

The app is easy to use, to add a new article you click the New Article button. To delete an article click the delete button, and to edit an article click the edit button.
I assumed no validation was necessary for the delete article function, however prompting the user for confirmation would add a slightly better UX for the user.
