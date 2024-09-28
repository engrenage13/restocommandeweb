import InputLabel from "./InputLabel";
import TextInput from "./TextInput";
import InputError from "./InputError";
import { ChangeEventHandler } from "react";

export interface IFormField {
  id: string;
  title: string;
  value: string|number;
  type: 'text'|'number'|'password'|'email';
  autoComplete?: string;
  onChange : ChangeEventHandler<HTMLInputElement>;
  isFocused?: boolean;
  required?: boolean;
  errorMessage?: string;
  className?: string;
}

export default function FormField({id, title, value, type = 'text', autoComplete, onChange, isFocused = false, required = false, errorMessage, className}: IFormField) {
  return (
    <div className={className}>
      <InputLabel htmlFor={id} value={title} />
      <TextInput
        id={id}
        name={id}
        type={type}
        value={value}
        className="mt-1 block w-full"
        autoComplete={autoComplete}
        isFocused={isFocused}
        onChange={onChange}
        required={required}
      />
      <InputError message={errorMessage} className="mt-2" />
    </div>
  );
}