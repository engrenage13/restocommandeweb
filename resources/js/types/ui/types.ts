export interface ILink {
  route: string;
  label: string;
  color?: string;
  method?: 'get'|'post'|'patch'|'put'|'delete';
}