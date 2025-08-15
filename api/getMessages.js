import { MongoClient } from "mongodb";

const uri = "mongodb+srv://<username>:<password>@cluster0.abcde.mongodb.net/mySite?retryWrites=true&w=majority";
const client = new MongoClient(uri);

export default async function handler(req, res) {
  if(req.method === "GET") {
    try {
      await client.connect();
      const db = client.db("mySite");
      const messages = await db.collection("messages").find().sort({date:-1}).toArray();
      res.status(200).json(messages);
    } catch(e) {
      res.status(500).json({ error: e.message });
    } finally {
      await client.close();
    }
  } else {
    res.status(405).json({ error: "Method not allowed" });
  }
}
