import { MongoClient } from "mongodb";

const uri = "mongodb+srv://<username>:<password>@cluster0.abcde.mongodb.net/mySite?retryWrites=true&w=majority";
const client = new MongoClient(uri);

export default async function handler(req, res) {
  if(req.method === "POST") {
    const { name, email, message } = req.body;
    try {
      await client.connect();
      const db = client.db("mySite");
      await db.collection("messages").insertOne({ name, email, message, date: new Date() });
      res.status(200).json({ status: "ok" });
    } catch(e) {
      res.status(500).json({ error: e.message });
    } finally {
      await client.close();
    }
  } else {
    res.status(405).json({ error: "Method not allowed" });
  }
}
