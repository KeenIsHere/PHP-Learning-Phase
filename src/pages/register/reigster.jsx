const Register = ({setCount}) => {
  return (
    <>
      <div
        style={{
          textAlign: "center",
          display: "flex",
          alignItems: "center",
          justifyContent: "center",
          height: "100vh",
        }}
      >
        <div
          style={{
            backgroundColor: "blue",
            height: "100%",
            backgroundImage: "url(./assets/register-bg.jpg)",
            backgroundSize: "cover",
            backgroundPosition: "center",
            flex: 1,
          }}
        ></div>
        <div
          style={{
            flex: 1,
            display: "flex",
            height: "100%",
            alignItems: "center",
            justifyContent: "center",
          }}
        >
          <form
            style={{
              display: "flex",
              maxWidth: "400px",
              width: "100%",
              height: "100%",
              alignItems: "center",
              flexDirection: "column",
              justifyContent: "center",
              gap: "10px",
            }}
          >
            <input
              className="input"
              type="text"
              placeholder="Enter your full name"
            />
            <input
              className="input"
              type="email"
              placeholder="Enter your email"
            />
            <input
              className="input"
              type="password"
              placeholder="Enter your password"
            />
            <button className="button" type="submit">
              Register
            </button>
          </form>
        </div>
      </div>
    </>
  );
};

export default Register;
