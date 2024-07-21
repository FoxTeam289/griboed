const express = require('express');
const WebSocket = require('ws');
const http = require('http');

const app = express();
const server = http.createServer(app);
const wss = new WebSocket.Server({ server });

let invitations = [];
let connectedClients = [];

wss.on('connection', (ws) => {
    console.log('New client connected');
    connectedClients.push(ws);

    ws.on('message', (message) => {
        const data = JSON.parse(message);
        switch (data.type) {
            case 'sendInvitation':
                invitations.push({ from: data.from, to: data.to });
                broadcast({ type: 'newInvitation', from: data.from, to: data.to });
                break;
            case 'acceptInvitation':
                const index = invitations.findIndex(inv => inv.from === data.from && inv.to === data.to);
                if (index !== -1) {
                    invitations.splice(index, 1);
                    broadcast({ type: 'invitationAccepted', from: data.from, to: data.to });
                }
                break;
            case 'declineInvitation':
                const declineIndex = invitations.findIndex(inv => inv.from === data.from && inv.to === data.to);
                if (declineIndex !== -1) {
                    invitations.splice(declineIndex, 1);
                    broadcast({ type: 'invitationDeclined', from: data.from, to: data.to });
                }
                break;
            case 'updateLocation':
                broadcast({ type: 'updateLocation', device: data.device, lat: data.lat, lon: data.lon });
                break;
        }
    });

    ws.on('close', () => {
        console.log('Client disconnected');
        connectedClients = connectedClients.filter(client => client !== ws);
    });
});

function broadcast(data) {
    connectedClients.forEach(client => {
        if (client.readyState === WebSocket.OPEN) {
            client.send(JSON.stringify(data));
        }
    });
}

app.use(express.static('public'));

server.listen(8080, () => {
    console.log('Server is listening on port 8080');
});
