export const onChangeChoice = (name, value, setFormData) => {
    setFormData((prev) => ({
      ...prev,
      [name]: value,
    }));
  };