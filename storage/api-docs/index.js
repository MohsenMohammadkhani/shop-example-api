const fs = require("fs");
let swagger = require("./init.json");
const user = require("./auth.json");
const permission = require("./permission.json");
const role = require("./role.json");
const product = require("./product.json");

swagger["paths"] = {
    ...user.paths,
    ...permission.paths,
    ...role.paths,
    ...product.paths,
};

swagger["definitions"] = {
    ...user.definitions,
    ...permission.definitions,
    ...role.definitions,
    ...product.definitions,
};

fs.writeFile(
    "./storage/api-docs/api-docs.json",
    JSON.stringify(swagger),
    (err) => {
        if (err) {
            console.error(err);
            return;
        }
        console.error("file is written successful");
    }
);
