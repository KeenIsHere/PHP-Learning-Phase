const Register = ({setCount}) => {
  return (
    <>
      <button onClick={() => setCount((prevCount) => prevCount + 1)}>
        Increase from register
      </button>
    </>
  );
};

export default Register;
