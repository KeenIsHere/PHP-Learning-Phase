import {useState} from "react";
import Login from "../pages/login/login";
import Register from "../pages/register/reigster";

function App() {
  const [count, setCount] = useState(1);

  console.log("App component rendered");
  return (
    <>
      <Login count={count} setCount={setCount} />
      <Register setCount={setCount} />
    </>
  );
}

export default App;
