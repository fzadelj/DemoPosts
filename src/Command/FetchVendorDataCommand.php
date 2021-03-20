<?php
declare(strict_types=1);


namespace App\Command;


use App\Repository\PostsRepository;
use App\Repository\UsersRepository;
use App\Vendor\PostsFetcherInterface;
use App\Vendor\UsersFetcherInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class FetchVendorDataCommand extends Command
{
    private UsersFetcherInterface $usersFetcher;
    private UsersRepository $usersRepository;
    private PostsRepository $postsRepository;
    private PostsFetcherInterface $postsFetcher;

    public function __construct(UsersFetcherInterface$usersFetcher, UsersRepository $usersRepository, PostsFetcherInterface $postsFetcher, PostsRepository $postsRepository)
    {
        parent::__construct('vendor:typicode:fetch');
        $this->usersFetcher = $usersFetcher;
        $this->usersRepository = $usersRepository;
        $this->postsFetcher = $postsFetcher;
        $this->postsRepository = $postsRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->syncUsers($output);

        $this->syncPosts($output);

        return self::SUCCESS;
    }

    private function syncUsers(OutputInterface $output): void
    {
        $batchCreator = $this->usersRepository->getNewBatchCreator();
        foreach ($this->usersFetcher->fetch() as $user) {
            $batchCreator->addUser($user);
        }

        $output->writeln(
            sprintf(
                'Updated %d users.',
                $batchCreator->save()
            )
        );
    }

    private function syncPosts(OutputInterface $output): void
    {
        $batchCreator = $this->postsRepository->getNewBatchCreator();
        foreach ($this->postsFetcher->fetch() as $post) {
            $batchCreator->addPost($post);
        }

        $output->writeln(
            sprintf(
                'Updated %d posts.',
                $batchCreator->save()
            )
        );
    }

}