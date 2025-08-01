import {useState} from "react";
import Login from "../pages/login/login";
import Register from "../pages/register/reigster";
import FlexExample from "../components/flex";

function App() {
  const [count, setCount] = useState(1);

  return (
    <>
      {/* <Login count={count} setCount={setCount} /> */}
      <Register setCount={setCount} />
      {/* <FlexExample /> */}
    </>
  );
}

export default App;
