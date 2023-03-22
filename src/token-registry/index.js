const jsonServer = require('json-server')
const bodyParser = require("body-parser");
const middlewares = jsonServer.defaults();
const server = jsonServer.create()
const fs = require( 'fs' );
const path = require( 'path' );

const dataDir = process.env.TOKEN_REGISTRY_MAPPINGS_DIR || path.join(__dirname, 'cardano-token-registry/mappings');
const listenPort = process.env.PORT || process.env.LISTEN_PORT || 3042;

var db = {};
// serve all files under git's mappings folder
var files = fs.readdirSync(dataDir);
files.forEach(function (file) {
  if (path.extname(dataDir + file) === '.json') {
      db[file.replace(/.json$/g, '')] = require(path.join(dataDir,file));
  }
});
// hack to enable json-server to handle /metadata/query path
db['query'] = {};

const router = jsonServer.router(db);

server.use(middlewares);

// Handle POST queries to /metadata/query
server.use(bodyParser.json())
server.use(bodyParser.urlencoded({
	extended: true
}));
server.use((req, res, next) => {
  if (req.method === 'GET' && req.originalUrl === '/metadata/healthcheck') {
    responseBody = { message: 'ok' }
    res.jsonp(responseBody)
  } else if (req.method === 'POST' && req.originalUrl === '/metadata/query') {

    responseBody = { subjects: [] }
    if ( req.body.subjects ) {
      req.body.subjects.forEach(function (subject) {
        try {
          subjectJson = JSON.parse(fs.readFileSync(path.join(dataDir,subject+'.json'), 'utf8'))
          responseBody.subjects.push(subjectJson)
        } catch(e) { console.log(`[!] Asset '${subject}' not found.`) }
      })
    }
    res.jsonp(responseBody)
  } else {
    next()
  }

})

// mount resources directly to /metadata instead of rewriting every req
server.use('/metadata', router);

server.listen(listenPort, () => {
  console.log(`[🚀] dbless-cardano-token-registry is running, you can query assets on http://localhost:${listenPort}`)
  console.log(`[ℹ️]] You can query assets using POST against /metadata/query or directly hex asset ids like http://localhost:${listenPort}/metadata/2b0a04a7b60132b1805b296c7fcb3b217ff14413991bf76f72663c3067696d62616c`)
})
