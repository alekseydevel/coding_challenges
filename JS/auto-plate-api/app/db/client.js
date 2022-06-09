import pkg from 'pg';
const { Client } = pkg;


// todo-1: wrap into singleton
// todo-2: register shutdown housekeeping handlers - remove connections in case of process.error
const client = new Client({
    host: 'db', // todo: introduce .env handling
    port: 5432,
    user: 'postgres',
    password: 'postgres',
    database: 'plates'
});

client.connect(err => {
    if (err) {
        console.error('connection error', err.stack);
        process.exit(1);
    } else {
        console.log('connected to DB')
    }
});

export { client };