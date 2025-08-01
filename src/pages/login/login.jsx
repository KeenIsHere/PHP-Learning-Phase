const Login = ({count, setCount}) => {
  function handleClick() {
    setCount((prev) => prev + 1);
  }

  console.log("Login component rendered");

  return (
    <div style={{}}>
      <p
        style={{
          fontSize: "2em",
          color: "#333",

          marginTop: "20px",
        }}
      >
        {count > 18 ? "You are allowed to vote" : "You are not allowed to vote"}
        {" (Count: " + count + ")"}
      </p>
      {count < 18 ? (
        <button onClick={handleClick}>Increase</button>
      ) : (
        <button onClick={() => setCount((prev) => prev - 1)}>Decrease</button>
      )}
    </div>
  );
};

export default Login;
