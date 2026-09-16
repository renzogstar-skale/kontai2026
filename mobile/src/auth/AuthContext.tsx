import { createContext, useContext, useEffect, useMemo, useState, type PropsWithChildren } from 'react';

import * as authApi from '@/src/api/auth';
import { clearToken, getToken, setToken } from '@/src/api/client';

type AuthContextValue = {
  user: authApi.User | null;
  isLoading: boolean;
  signIn: (email: string, password: string) => Promise<void>;
  signOut: () => Promise<void>;
};

const AuthContext = createContext<AuthContextValue | null>(null);

export function AuthProvider({ children }: PropsWithChildren) {
  const [user, setUser] = useState<authApi.User | null>(null);
  const [isLoading, setIsLoading] = useState(true);

  useEffect(() => {
    // DEMO MODE: Bypass auth completely and provide a mock user
    setUser({
      id: 1,
      first_name: 'RENZO',
      last_name: 'GIOVINE',
      email: 'renzo@demo.com',
      role: 'staff',
      stores: []
    } as any);
    setIsLoading(false);
  }, []);

  const signIn = async (email: string, password: string) => {
    const { token, user: loggedInUser } = await authApi.login(email, password);
    await setToken(token);
    setUser(loggedInUser);
  };

  const signOut = async () => {
    try {
      await authApi.logout();
    } catch {
      // Le token est peut-être déjà invalide côté serveur (expiré, révoqué) —
      // on nettoie quand même la session locale.
    }
    await clearToken();
    setUser(null);
  };

  const value = useMemo(() => ({ user, isLoading, signIn, signOut }), [user, isLoading]);

  return <AuthContext.Provider value={value}>{children}</AuthContext.Provider>;
}

export function useAuth(): AuthContextValue {
  const ctx = useContext(AuthContext);
  if (!ctx) {
    throw new Error('useAuth() doit être utilisé à l\'intérieur de <AuthProvider>.');
  }
  return ctx;
}
