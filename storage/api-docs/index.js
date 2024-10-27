const fs = require("fs");
let swagger = require("./init.json");
const auth = require("./auth.json");
const permission = require("./permission.json");
const role = require("./role.json");
const product = require("./product.json");
const user = require("./user.json");

swagger["paths"] = {
    ...auth.paths,
    ...permission.paths,
    ...role.paths,
    ...product.paths,
    ...user.paths,
};

swagger["definitions"] = {
    ...auth.definitions,
    ...permission.definitions,
    ...role.definitions,
    ...product.definitions,
    ...user.definitions,
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
