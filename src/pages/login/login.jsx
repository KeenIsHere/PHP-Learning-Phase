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
        {count}
      </p>
      <button onClick={handleClick}>Count</button>
    </div>
  );
};

export default Login;
