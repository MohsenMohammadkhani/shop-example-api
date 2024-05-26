const fs = require("fs");
let swagger = require("./init.json");
const user = require("./auth.json");
const permission = require("./permission.json");
const role = require("./role.json");

swagger["paths"] = {
    ...user.paths,
    ...permission.paths,
    ...role.paths,
};

swagger["definitions"] = {
    ...user.definitions,
    ...permission.definitions,
    ...role.definitions,
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
