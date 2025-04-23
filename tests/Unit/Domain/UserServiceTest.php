<?php
namespace Tests\Unit\Domain;

use App\Domain\User\Entities\User;
use App\Domain\User\Exceptions\UserException;
use App\Domain\User\Repositories\UserRepositoryInterface;
use App\Domain\User\Services\UserService;
use App\Domain\User\ValueObjects\Country;
use App\Domain\User\ValueObjects\Email;
use App\Domain\User\ValueObjects\Gender;
use App\Domain\User\ValueObjects\Name;
use App\Domain\User\ValueObjects\Phone;
use Mockery;
use Tests\TestCase;

class UserServiceTest extends TestCase
{
    private $repository;
    private $userService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(UserRepositoryInterface::class);
        $this->userService = new UserService($this->repository);
    }

    public function test_create_user_successfully()
    {
        $name = new Name('John');
        $surname = new Name('Doe');
        $email = new Email('john.doe@example.com');
        $phone = new Phone('+1234567890');
        $country = new Country('United States');
        $gender = new Gender('male');
        $password = 'password123';
        $profilePicture = 'profiles/photo.jpg';

        $user = new User($name, $surname, $email, $phone, $country, $gender, $password, $profilePicture);

        $this->repository->shouldReceive('findByEmail')->with($email)->andReturn(null);
        $this->repository->shouldReceive('save')->with(Mockery::type(User::class))->once();

        $result = $this->userService->create($name, $surname, $email, $phone, $country, $gender, $password, $profilePicture);

        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('john.doe@example.com', $result->getEmail()->getValue());
    }

    public function test_create_user_with_existing_email_throws_exception()
    {
        $email = new Email('john.doe@example.com');
        $this->repository->shouldReceive('findByEmail')->with($email)->andReturn(new User(
            new Name('John'),
            new Name('Doe'),
            $email,
            new Phone('+1234567890'),
            new Country('United States'),
            new Gender('male'),
            'password123'
        ));

        $this->expectException(UserException::class);
        $this->expectExceptionMessage('User with this email already exists');

        $this->userService->create(
            new Name('John'),
            new Name('Doe'),
            $email,
            new Phone('+1234567890'),
            new Country('United States'),
            new Gender('male'),
            'password123',
            null
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
