import { useRef, useState, FormEventHandler } from 'react';
import DangerButton from '@/Components/Buttons/DangerButton';
import Modal from '@/Components/Modal';
import SecondaryButton from '@/Components/Buttons/SecondaryButton';
import { useForm } from '@inertiajs/react';
import FormField, { IFormField } from '@/Components/Form/FormField';

export default function DeleteUserForm({ className = '' }: { className?: string }) {
  const [confirmingUserDeletion, setConfirmingUserDeletion] = useState(false);
  const passwordInput = useRef<HTMLInputElement>(null);

  const {
    data,
    setData,
    delete: destroy,
    processing,
    reset,
    errors,
    clearErrors,
  } = useForm({
    password: '',
  });

  const confirmUserDeletion = () => {
    setConfirmingUserDeletion(true);
  };

  const deleteUser: FormEventHandler = (e) => {
    e.preventDefault();

    destroy(route('profile.destroy'), {
      preserveScroll: true,
      onSuccess: () => closeModal(),
      onError: () => passwordInput.current?.focus(),
      onFinish: () => reset(),
    });
  };

  const closeModal = () => {
    setConfirmingUserDeletion(false);

    clearErrors();
    reset();
  };

  const fields: IFormField[] = [
    {id: 'password', title: 'Mot de passe', value: data.password, type:'password', autoComplete: 'new-password', isFocused: true, onChange: (e) => setData('password', e.target.value), required: true, errorMessage: errors.password, className: 'mt-6'},
  ];

  return (
    <section className={`space-y-6 ${className}`}>
      <header>
        <h2 className="text-lg font-medium text-gray-900">Supprimer mon compte</h2>

        <p className="mt-1 text-sm text-gray-600">
          Si vous supprimez votre compte vous perdrez toutes vos informations sur Resto Commande.
        </p>
      </header>
      <DangerButton onClick={confirmUserDeletion} className="max-w-max">Supprimer mon compte</DangerButton>
      <Modal show={confirmingUserDeletion} onClose={closeModal}>
        <form onSubmit={deleteUser} className="p-6">
          <h2 className="text-lg font-medium text-gray-900">
            Êtes-vous sûr de vouloir supprimer votre compte ?
          </h2>
          <p className="mt-1 text-sm text-gray-600">
            Cette action est irréversible. Quand votre compte sera supprimez, vous perdrez toutes vos informations.
          </p>
          {fields.map(x => <FormField {...x} />)}

          <div className="mt-6 flex justify-center sm:justify-end">
            <SecondaryButton onClick={closeModal}>Annuler</SecondaryButton>

            <DangerButton className="ms-3" disabled={processing}>
              Supprimer mon compte
            </DangerButton>
          </div>
        </form>
      </Modal>
    </section>
  );
}
