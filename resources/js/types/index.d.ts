export interface User {
  id: number;
  firstname: string;
  lastname: string;
  email: string;
  admin_level?: number;
  email_verified_at?: string;
}

export type PageProps<T extends Record<string, unknown> = Record<string, unknown>> = T & {
  auth: {
    user: User;
  };
};
