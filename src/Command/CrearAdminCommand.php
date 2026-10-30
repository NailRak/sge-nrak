<?php

namespace App\Command;

use App\Entity\Usuario;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:crear-admin',
    description: 'Crea un nuevo usuario administrador de forma interactiva.',
)]
class CrearAdminCommand extends Command
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private UsuarioRepository $usuarioRepository
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Alta de administrador');

        // 1. Pedir datos obligatorios de la entidad Usuario
        $nombre = trim((string) $io->ask('Nombre'));
        if (empty($nombre)) {
            $io->error('El nombre no puede estar vacío.');
            return Command::FAILURE;
        }

        $apellido = trim((string) $io->ask('Apellido'));
        if (empty($apellido)) {
            $io->error('El apellido no puede estar vacío.');
            return Command::FAILURE;
        }

        $dni = trim((string) $io->ask('DNI'));
        if (empty($dni)) {
            $io->error('El DNI no puede estar vacío.');
            return Command::FAILURE;
        }

        $direccion = trim((string) $io->ask('Dirección'));
        if (empty($direccion)) {
            $io->error('La dirección no puede estar vacía.');
            return Command::FAILURE;
        }

        $telefono = trim((string) $io->ask('Teléfono'));
        if (empty($telefono)) {
            $io->error('El teléfono no puede estar vacío.');
            return Command::FAILURE;
        }

        // 2. Pedir y validar Email
        $email = trim((string) $io->ask('Correo electrónico'));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $io->error('Correo electrónico no válido.');
            return Command::FAILURE;
        }

        if ($this->usuarioRepository->findOneBy(['email' => $email])) {
            $io->error('Ya existe un usuario con ese correo.');
            return Command::FAILURE;
        }

        // 3. Pedir Contraseña de forma oculta
        $helper = $this->getHelper('question');
        
        $pregunta = new Question('Contraseña: ');
        $pregunta->setHidden(true);
        $pregunta->setHiddenFallback(false);
        $password = $helper->ask($input, $output, $pregunta);

        if (!is_string($password) || strlen($password) < 6) {
            $io->error('La contraseña debe tener al menos 6 caracteres.');
            return Command::FAILURE;
        }

        // 4. Confirmar Contraseña
        $confirmacion = new Question('Confirmar contraseña: ');
        $confirmacion->setHidden(true);
        $confirmacion->setHiddenFallback(false);
        $repetida = $helper->ask($input, $output, $confirmacion);

        if ($password !== $repetida) {
            $io->error('Las contraseñas no coinciden.');
            return Command::FAILURE;
        }

        // 5. Crear y guardar el usuario con todos sus campos
        $usuario = new Usuario();
        $usuario->setNombre($nombre);
        $usuario->setApellido($apellido);
        $usuario->setDni($dni);
        $usuario->setDireccion($direccion);
        $usuario->setTelefono($telefono);
        $usuario->setEmail($email);
        $usuario->setRoles(['ROLE_ADMIN']);

        $hash = $this->passwordHasher->hashPassword($usuario, $password);
        $usuario->setPassword($hash);

        $this->entityManager->persist($usuario);
        $this->entityManager->flush();

        $io->success('¡Administrador creado correctamente!');
        return Command::SUCCESS;
    }
}