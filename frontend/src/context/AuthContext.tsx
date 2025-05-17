import { createContext, useState, useContext, ReactNode } from "react";

/**
 * Kiểu dữ liệu người dùng.
 */
type User = {
  id: string;
  name: string;
  email: string;
  phone: string;
};

/**
 * Kiểu context.
 */
type AuthContextType = {
  user: User | null;
  login: (userInput: string, password: string) => boolean;
  logout: () => void;
};

// Dữ liệu người dùng mẫu
const mockUser = {
  id: "00001",
  name: "Dova",
  email: "abc@gmail.com",
  phone: "0123456789",
  password: "123456",
};

const AuthContext = createContext<AuthContextType | undefined>(undefined);

export const AuthProvider = ({ children }: { children: ReactNode }) => {
  const [user, setUser] = useState<User | null>(null);

  /**
   * Hàm đăng nhập kiểm tra dữ liệu đầu vào với mockUser.
   */
  const login = (userInput: string, password: string): boolean => {
    if ((userInput === mockUser.email || userInput === mockUser.phone) && password === mockUser.password) {
      const { password, ...userData } = mockUser;
      setUser(userData);
      return true;
    }
    return false;
  };

  const logout = () => {
    setUser(null);
  };

  return (
    <AuthContext.Provider value={{ user, login, logout }}>
      {children}
    </AuthContext.Provider>
  );
};

/**
 * Hook để truy cập AuthContext một cách an toàn.
 */
export const useAuth = () => {
  const context = useContext(AuthContext);
  if (!context) {
    throw new Error("useAuth must be used within an AuthProvider");
  }
  return context;
};
