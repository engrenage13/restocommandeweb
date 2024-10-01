import { useRef, FormEventHandler } from 'react';
import PrimaryButton from '@/Components/Buttons/PrimaryButton';
import { useForm } from '@inertiajs/react';
import { Transition } from '@headlessui/react';
import FormField, { IFormField } from '@/Components/Form/FormField';

export default function UpdatePasswordForm({ className = '' }: { className?: string }) {
  const passwordInput = useRef<HTMLInputElement>(null);
  const currentPasswordInput = useRef<HTMLInputElement>(null);

  const { data, setData, errors, put, reset, processing, recentlySuccessful } = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
  });

  const updatePassword: FormEventHandler = (e) => {
    e.preventDefault();

    put(route('password.update'), {
      preserveScroll: true,
      onSuccess: () => reset(),
      onError: (errors) => {
        if (errors.password) {
          reset('password', 'password_confirmation');
          passwordInput.current?.focus();
        }

        if (errors.current_password) {
          reset('current_password');
          currentPasswordInput.current?.focus();
        }
      },
    });
  };

  const fields: IFormField[] = [
    {id: 'current_password', title: 'Mot de passe actuel', value: data.current_password, type:'password', autoComplete: 'password', isFocused: true, onChange: (e) => setData('current_password', e.target.value), required: true, errorMessage: errors.current_password},
    {id: 'password', title: 'Nouveau mot de passe', value: data.password, type:'password', autoComplete: 'new-password', onChange: (e) => setData('password', e.target.value), required: true, errorMessage: errors.password, className:'mt-4'},
    {id: 'password_confirmation', title: 'Confirmer le nouveau mot de passe', value: data.password_confirmation, type:'password', autoComplete: 'new-password', onChange: (e) => setData('password_confirmation', e.target.value), required: true, errorMessage: errors.password_confirmation, className: 'mt-4'},
  ];

  return (
    <section className={className}>
      <header>
        <h2 className="text-lg font-medium text-gray-900">Modifiez votre mot de passe</h2>

        <p className="mt-1 text-sm text-gray-600">
          Plus votre mot de passe est long et incohérent plus il sera sécurisé.
        </p>
      </header>
      <form onSubmit={updatePassword} className="mt-6 space-y-6">
        {fields.map(x => <FormField {...x} />)}
        <div className="flex items-center gap-4">
          <PrimaryButton disabled={processing}>Sauvegarder</PrimaryButton>

          <Transition
            show={recentlySuccessful}
            enter="transition ease-in-out"
            enterFrom="opacity-0"
            leave="transition ease-in-out"
            leaveTo="opacity-0"
          >
            <p className="text-sm text-gray-600">Enregistré</p>
          </Transition>
        </div>
      </form>
    </section>
  );
}
