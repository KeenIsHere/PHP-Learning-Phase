const FlexExample = () => {
  return (
    <div
      style={{
        height: "100vh",
        backgroundColor: "red",
        display: "flex",
        gap: "20px",
        flexDirection: "row",
        justifyContent: "space-evenly",
        alignItems: "center",
      }}
    >
      <div
        style={{
          flex: "5",
          height: "100px",
          width: "100px",
          backgroundColor: "blue",
        }}
      ></div>
      <div
        style={{
          flex: "1",
          height: "100px",
          width: "100px",
          backgroundColor: "blue",
        }}
      ></div>
      <div
        style={{
          flex: "1",
          height: "100px",
          width: "100px",
          backgroundColor: "blue",
        }}
      ></div>
    </div>
  );
};

export default FlexExample;
