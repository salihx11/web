// Simple API route to fix Vercel deployment
export default function handler(req, res) {
  res.status(200).json({ 
    status: 'OK', 
    message: 'CoinSpark Admin API is running' 
  })
}
