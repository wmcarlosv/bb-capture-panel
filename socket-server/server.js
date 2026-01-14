require('dotenv').config({ path: '../.env' }); // Leer .env del directorio padre
const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const cors = require('cors');
const bodyParser = require('body-parser');

const app = express();
app.use(cors());
app.use(bodyParser.json());

const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: "*", 
        methods: ["GET", "POST"]
    }
});

// Endpoint interno que llamará PHP
app.post('/notify-new-customer', (req, res) => {
    const customerData = req.body;
    
    console.log('Nuevo cliente recibido desde PHP:', customerData.dni);
    
    // Emitir evento a todos los navegadores conectados
    io.emit('new_customer', customerData);
    
    res.json({ success: true });
});

// Endpoint para notificar actualización (Paso 2)
app.post('/notify-update-customer', (req, res) => {
    const customerData = req.body;
    console.log('Cliente actualizado recibido:', customerData.id);
    io.emit('update_customer', customerData);
    res.json({ success: true });
});

io.on('connection', (socket) => {
    console.log('Un cliente se conectó al Dashboard Real-time');
    
    socket.on('disconnect', () => {
        console.log('Cliente desconectado');
    });
});

const PORT = process.env.SOCKET_PORT || 3000;
server.listen(PORT, () => {
    console.log(`Socket Server corriendo en el puerto ${PORT}`);
});