# 🎉 Mad Events - Event Management Platform

<div align="center">
  <img src="https://img.shields.io/badge/PHP-8.0+-purple.svg" alt="PHP Version"/>
  <img src="https://img.shields.io/badge/Symfony-6.0-black.svg" alt="Symfony"/>
  <img src="https://img.shields.io/badge/Doctrine-ORM-orange.svg" alt="Doctrine"/>
  <img src="https://img.shields.io/badge/Twig-Template-green.svg" alt="Twig"/>
  <img src="https://img.shields.io/badge/MySQL-Database-blue.svg" alt="MySQL"/>
</div>

<p align="center">
  <strong>🎯 Complete event management platform built with Symfony, featuring user authentication, data persistence, and modern web architecture</strong>
</p>

---

## 📊 **Project Overview**

**Mad Events** is a sophisticated event management platform developed with **PHP 8.0+** and **Symfony 6.0**. The application provides comprehensive event organization capabilities including user authentication, event creation and management, participant registration, and administrative functions with a clean, modern interface powered by **Twig** templating engine and **Doctrine ORM**.

### 🎯 **Key Features**

- **🔐 User Authentication**: Secure login and registration system
- **🎪 Event Management**: Create, edit, and manage events
- **👥 User Management**: Profile management and user roles
- **📅 Event Calendar**: Interactive calendar with event scheduling
- **💾 Data Persistence**: MySQL database with Doctrine ORM
- **🔄 RESTful Routing**: Clean URLs and proper HTTP methods
- **🎨 Modern UI**: Responsive design with Twig templates
- **🐳 Docker Support**: Containerized development environment

---

## 🛠️ **Technical Stack**

### **Backend Framework**
- **🐘 PHP 8.0.2+**: Modern PHP with latest features and performance improvements
- **🎼 Symfony 6.0**: High-performance PHP framework for web applications
- **🗃️ Doctrine ORM 2.11**: Database abstraction layer and object-relational mapping
- **🔄 Doctrine Migrations**: Database schema version control

### **Frontend & Templating**
- **🎨 Twig 3.0**: Flexible, fast, and secure templating engine
- **💄 CSS3**: Modern styling with responsive design
- **⚡ JavaScript**: Interactive frontend functionality
- **📱 Responsive Design**: Mobile-first responsive web design

### **Database & Persistence**
- **🗄️ MySQL**: Relational database management system
- **🔧 Doctrine Bundle**: Symfony integration for Doctrine ORM
- **📊 Database Migrations**: Version-controlled schema management

### **Development Tools**
- **🐳 Docker**: Containerized development environment
- **🔧 Symfony Maker Bundle**: Code generation and scaffolding
- **🐛 Web Profiler**: Development debugging and profiling
- **⏱️ Stopwatch**: Performance monitoring and optimization

### **Security & Authentication**
- **🔐 Symfony Security**: Built-in authentication and authorization
- **🔑 Form Handling**: Secure form processing and validation
- **🛡️ CSRF Protection**: Cross-site request forgery protection

---

## 🚀 **Quick Start**

### **Prerequisites**
- PHP 8.0+ with required extensions
- Composer for dependency management
- MySQL 8.0+ or MariaDB
- Docker & Docker Compose (optional)

### **Installation**

#### **Traditional Setup**
```bash
# Clone the repository
git clone https://github.com/AlfonsoCifuentes/mad-events.git
cd mad-events

# Install dependencies
composer install

# Configure environment
cp .env .env.local
# Edit .env.local with your database credentials

# Create database and run migrations
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate

# Start development server
symfony server:start
# or
php -S localhost:8000 -t public/
```

#### **Docker Setup**
```bash
# Clone and start with Docker
git clone https://github.com/AlfonsoCifuentes/mad-events.git
cd mad-events

# Start Docker containers
docker-compose up -d

# Install dependencies in container
docker-compose exec php composer install

# Run database migrations
docker-compose exec php bin/console doctrine:migrations:migrate
```

### **Available Commands**
```bash
# Development
symfony console cache:clear          # Clear application cache
symfony console doctrine:fixtures:load  # Load sample data
symfony console make:entity             # Create new entity
symfony console make:controller         # Create new controller

# Database
symfony console doctrine:schema:update --force  # Update database schema
symfony console doctrine:query:sql "SELECT * FROM events"  # Run SQL query

# Production
composer install --no-dev --optimize-autoloader
symfony console cache:warmup --env=prod
```

---

## 🏗️ **Project Architecture**

### **Directory Structure**
```
mad-events/
├── bin/                    # Executable files
├── config/                 # Configuration files
│   ├── packages/          # Package configurations
│   ├── routes/            # Routing definitions
│   └── services.yaml      # Service container configuration
├── migrations/            # Database migrations
├── public/               # Web root directory
│   ├── index.php         # Application entry point
│   ├── css/              # Stylesheets
│   └── js/               # JavaScript files
├── src/                  # Source code
│   ├── Controller/       # Controllers
│   ├── Entity/           # Doctrine entities
│   ├── Form/             # Form types
│   ├── Repository/       # Data repositories
│   ├── Security/         # Security components
│   └── Service/          # Business logic services
├── templates/            # Twig templates
│   ├── base.html.twig    # Base template
│   ├── event/            # Event-related templates
│   ├── user/             # User-related templates
│   └── security/         # Authentication templates
├── docker-compose.yml    # Docker configuration
├── composer.json         # PHP dependencies
└── .env                  # Environment variables
```

### **Key Components**

#### **🎪 Event Entity & Management**
```php
// src/Entity/Event.php
#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?\DateTimeInterface $eventDate = null;

    #[ORM\Column]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $organizer = null;

    #[ORM\OneToMany(mappedBy: 'event', targetEntity: Registration::class)]
    private Collection $registrations;

    // Getters and setters...
}
```

#### **👥 User Authentication System**
```php
// src/Entity/User.php
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    private ?string $lastName = null;

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }
}
```

#### **🎫 Event Controller**
```php
// src/Controller/EventController.php
#[Route('/events')]
class EventController extends AbstractController
{
    #[Route('/', name: 'event_index', methods: ['GET'])]
    public function index(EventRepository $eventRepository): Response
    {
        return $this->render('event/index.html.twig', [
            'events' => $eventRepository->findAllUpcoming(),
        ]);
    }

    #[Route('/new', name: 'event_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $event = new Event();
        $form = $this->createForm(EventType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setOrganizer($this->getUser());
            $event->setCreatedAt(new \DateTime());
            
            $entityManager->persist($event);
            $entityManager->flush();

            $this->addFlash('success', 'Event created successfully!');
            return $this->redirectToRoute('event_show', ['id' => $event->getId()]);
        }

        return $this->render('event/new.html.twig', [
            'event' => $event,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'event_show', methods: ['GET'])]
    public function show(Event $event): Response
    {
        return $this->render('event/show.html.twig', [
            'event' => $event,
        ]);
    }
}
```

---

## 🎨 **Frontend & Templates**

### **🎨 Twig Templating**

#### **Base Template**
```twig
{# templates/base.html.twig #}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{% block title %}Mad Events{% endblock %}</title>
    
    {% block stylesheets %}
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    {% endblock %}
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="{{ path('app_home') }}">Mad Events</a>
            
            <div class="navbar-nav ms-auto">
                {% if is_granted('ROLE_USER') %}
                    <a class="nav-link" href="{{ path('event_index') }}">Events</a>
                    <a class="nav-link" href="{{ path('event_new') }}">Create Event</a>
                    <a class="nav-link" href="{{ path('app_logout') }}">Logout</a>
                {% else %}
                    <a class="nav-link" href="{{ path('app_login') }}">Login</a>
                    <a class="nav-link" href="{{ path('app_register') }}">Register</a>
                {% endif %}
            </div>
        </div>
    </nav>

    <main class="container mt-4">
        {% for flash_message in app.flashes('success') %}
            <div class="alert alert-success">{{ flash_message }}</div>
        {% endfor %}
        
        {% for flash_message in app.flashes('error') %}
            <div class="alert alert-danger">{{ flash_message }}</div>
        {% endfor %}

        {% block body %}{% endblock %}
    </main>

    {% block javascripts %}
        <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('js/app.js') }}"></script>
    {% endblock %}
</body>
</html>
```

#### **Event Listing Template**
```twig
{# templates/event/index.html.twig #}
{% extends 'base.html.twig' %}

{% block title %}Upcoming Events{% endblock %}

{% block body %}
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Upcoming Events</h1>
    {% if is_granted('ROLE_USER') %}
        <a href="{{ path('event_new') }}" class="btn btn-primary">Create New Event</a>
    {% endif %}
</div>

<div class="row">
    {% for event in events %}
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100">
                <div class="card-body">
                    <h5 class="card-title">{{ event.title }}</h5>
                    <p class="card-text">{{ event.description|slice(0, 100) }}...</p>
                    <p class="text-muted">
                        <i class="fas fa-calendar"></i> 
                        {{ event.eventDate|date('F j, Y g:i A') }}
                    </p>
                    <p class="text-muted">
                        <i class="fas fa-user"></i> 
                        {{ event.organizer.firstName }} {{ event.organizer.lastName }}
                    </p>
                </div>
                <div class="card-footer">
                    <a href="{{ path('event_show', {'id': event.id}) }}" class="btn btn-outline-primary">
                        View Details
                    </a>
                </div>
            </div>
        </div>
    {% else %}
        <div class="col-12">
            <div class="alert alert-info text-center">
                <h4>No events scheduled</h4>
                <p>Be the first to create an event!</p>
                <a href="{{ path('event_new') }}" class="btn btn-primary">Create Event</a>
            </div>
        </div>
    {% endfor %}
</div>
{% endblock %}
```

### **📱 Responsive Design**
```css
/* public/css/app.css */
.event-card {
    transition: transform 0.2s ease-in-out;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.event-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0,0,0,0.15);
}

.navbar-brand {
    font-weight: bold;
    font-size: 1.5rem;
}

@media (max-width: 768px) {
    .container {
        padding: 0 15px;
    }
    
    .card-columns {
        column-count: 1;
    }
}

.btn-primary {
    background: linear-gradient(45deg, #007bff, #0056b3);
    border: none;
}

.alert {
    border-radius: 8px;
    margin-bottom: 20px;
}
```

---

## 🔐 **Security Implementation**

### **🔑 Authentication Configuration**
```yaml
# config/packages/security.yaml
security:
    password_hashers:
        App\Entity\User:
            algorithm: auto

    providers:
        app_user_provider:
            entity:
                class: App\Entity\User
                property: email

    firewalls:
        dev:
            pattern: ^/(_(profiler|wdt)|css|images|js)/
            security: false
        main:
            lazy: true
            provider: app_user_provider
            form_login:
                login_path: app_login
                check_path: app_login
                default_target_path: event_index
            logout:
                path: app_logout
                target: app_home
            custom_authenticator: App\Security\LoginFormAuthenticator

    access_control:
        - { path: ^/admin, roles: ROLE_ADMIN }
        - { path: ^/events/new, roles: ROLE_USER }
        - { path: ^/events/edit, roles: ROLE_USER }
```

### **🛡️ Form Security**
```php
// src/Form/EventType.php
class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Event title is required']),
                    new Length([
                        'min' => 3,
                        'max' => 255,
                        'minMessage' => 'Title must be at least {{ limit }} characters',
                        'maxMessage' => 'Title cannot exceed {{ limit }} characters'
                    ])
                ]
            ])
            ->add('description', TextareaType::class, [
                'constraints' => [
                    new NotBlank(['message' => 'Event description is required']),
                    new Length(['max' => 2000])
                ]
            ])
            ->add('eventDate', DateTimeType::class, [
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank(['message' => 'Event date is required']),
                    new GreaterThan([
                        'value' => 'now',
                        'message' => 'Event date must be in the future'
                    ])
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create Event',
                'attr' => ['class' => 'btn btn-primary']
            ]);
    }
}
```

---

## 🗄️ **Database Design**

### **📊 Entity Relationships**
```php
// Database Schema Overview

// Events Table
CREATE TABLE event (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT NOT NULL,
    event_date DATETIME NOT NULL,
    created_at DATETIME NOT NULL,
    organizer_id INT NOT NULL,
    FOREIGN KEY (organizer_id) REFERENCES user(id)
);

// Users Table
CREATE TABLE user (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(180) UNIQUE NOT NULL,
    roles JSON NOT NULL,
    password VARCHAR(255) NOT NULL,
    first_name VARCHAR(255) NOT NULL,
    last_name VARCHAR(255) NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

// Registrations Table (Many-to-Many)
CREATE TABLE registration (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    event_id INT NOT NULL,
    registered_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    status ENUM('pending', 'confirmed', 'cancelled') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES user(id),
    FOREIGN KEY (event_id) REFERENCES event(id),
    UNIQUE KEY unique_registration (user_id, event_id)
);
```

### **🔄 Migrations**
```php
// migrations/Version20240101000000.php
final class Version20240101000000 extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE event (
            id INT AUTO_INCREMENT NOT NULL, 
            organizer_id INT NOT NULL, 
            title VARCHAR(255) NOT NULL, 
            description LONGTEXT NOT NULL, 
            event_date DATETIME NOT NULL, 
            created_at DATETIME NOT NULL, 
            INDEX IDX_3BAE0AA7876C4DDA (organizer_id), 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        
        $this->addSql('ALTER TABLE event ADD CONSTRAINT FK_3BAE0AA7876C4DDA 
                      FOREIGN KEY (organizer_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE event');
    }
}
```

---

## 🐳 **Docker Configuration**

### **🐳 Docker Compose**
```yaml
# docker-compose.yml
version: '3.8'

services:
  php:
    build:
      context: .
      dockerfile: Dockerfile
    container_name: mad_events_php
    volumes:
      - .:/var/www/html
    depends_on:
      - database
    environment:
      - APP_ENV=dev
      - DATABASE_URL=mysql://mad_user:mad_password@database:3306/mad_events

  nginx:
    image: nginx:alpine
    container_name: mad_events_nginx
    ports:
      - "8080:80"
    volumes:
      - .:/var/www/html
      - ./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf
    depends_on:
      - php

  database:
    image: mysql:8.0
    container_name: mad_events_db
    environment:
      MYSQL_ROOT_PASSWORD: root_password
      MYSQL_DATABASE: mad_events
      MYSQL_USER: mad_user
      MYSQL_PASSWORD: mad_password
    ports:
      - "3306:3306"
    volumes:
      - mysql_data:/var/lib/mysql

volumes:
  mysql_data:
```

### **🐘 PHP Dockerfile**
```dockerfile
# Dockerfile
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY . .

# Install dependencies
RUN composer install --optimize-autoloader

# Set permissions
RUN chown -R www-data:www-data /var/www/html/var

EXPOSE 9000
CMD ["php-fpm"]
```

---

## 🔧 **Advanced Features**

### **📊 Event Analytics**
```php
// src/Service/EventAnalyticsService.php
class EventAnalyticsService
{
    public function __construct(
        private EventRepository $eventRepository,
        private EntityManagerInterface $entityManager
    ) {}

    public function getEventStatistics(): array
    {
        $totalEvents = $this->eventRepository->count([]);
        $upcomingEvents = $this->eventRepository->countUpcoming();
        $pastEvents = $totalEvents - $upcomingEvents;
        
        $popularEvents = $this->entityManager->createQuery('
            SELECT e.title, COUNT(r.id) as registration_count
            FROM App\Entity\Event e
            LEFT JOIN App\Entity\Registration r WITH r.event = e
            GROUP BY e.id
            ORDER BY registration_count DESC
        ')->setMaxResults(5)->getResult();

        return [
            'total_events' => $totalEvents,
            'upcoming_events' => $upcomingEvents,
            'past_events' => $pastEvents,
            'popular_events' => $popularEvents
        ];
    }
}
```

### **📧 Email Notifications**
```php
// src/Service/NotificationService.php
class NotificationService
{
    public function __construct(private MailerInterface $mailer) {}

    public function sendEventConfirmation(User $user, Event $event): void
    {
        $email = (new Email())
            ->from('noreply@madevents.com')
            ->to($user->getEmail())
            ->subject('Event Registration Confirmed')
            ->html($this->renderTemplate('email/event_confirmation.html.twig', [
                'user' => $user,
                'event' => $event
            ]));

        $this->mailer->send($email);
    }

    public function sendEventReminder(Event $event): void
    {
        foreach ($event->getRegistrations() as $registration) {
            $email = (new Email())
                ->from('noreply@madevents.com')
                ->to($registration->getUser()->getEmail())
                ->subject('Event Reminder: ' . $event->getTitle())
                ->html($this->renderTemplate('email/event_reminder.html.twig', [
                    'user' => $registration->getUser(),
                    'event' => $event
                ]));

            $this->mailer->send($email);
        }
    }
}
```

---

## 🧪 **Testing Strategy**

### **🧪 Unit Tests**
```php
// tests/Service/EventAnalyticsServiceTest.php
class EventAnalyticsServiceTest extends TestCase
{
    private EventAnalyticsService $analyticsService;
    private MockObject $eventRepository;
    private MockObject $entityManager;

    protected function setUp(): void
    {
        $this->eventRepository = $this->createMock(EventRepository::class);
        $this->entityManager = $this->createMock(EntityManagerInterface::class);
        
        $this->analyticsService = new EventAnalyticsService(
            $this->eventRepository,
            $this->entityManager
        );
    }

    public function testGetEventStatistics(): void
    {
        $this->eventRepository->expects($this->once())
            ->method('count')
            ->willReturn(10);

        $this->eventRepository->expects($this->once())
            ->method('countUpcoming')
            ->willReturn(6);

        $statistics = $this->analyticsService->getEventStatistics();

        $this->assertEquals(10, $statistics['total_events']);
        $this->assertEquals(6, $statistics['upcoming_events']);
        $this->assertEquals(4, $statistics['past_events']);
    }
}
```

### **🌐 Integration Tests**
```php
// tests/Controller/EventControllerTest.php
class EventControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    public function testEventListPage(): void
    {
        $this->client->request('GET', '/events');
        
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Upcoming Events');
    }

    public function testCreateEventRequiresAuthentication(): void
    {
        $this->client->request('GET', '/events/new');
        
        $this->assertResponseRedirects('/login');
    }

    public function testAuthenticatedUserCanCreateEvent(): void
    {
        $this->loginUser();
        
        $crawler = $this->client->request('GET', '/events/new');
        $form = $crawler->selectButton('Create Event')->form();
        
        $form['event[title]'] = 'Test Event';
        $form['event[description]'] = 'This is a test event';
        $form['event[eventDate]'] = '2024-12-31T23:59';
        
        $this->client->submit($form);
        
        $this->assertResponseRedirects();
        $this->assertSelectorTextContains('.alert-success', 'Event created successfully');
    }
}
```

---

## 📊 **Performance Optimization**

### **⚡ Doctrine Optimization**
```php
// src/Repository/EventRepository.php
class EventRepository extends ServiceEntityRepository
{
    public function findUpcomingWithRegistrations(): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.registrations', 'r')
            ->leftJoin('e.organizer', 'o')
            ->addSelect('r', 'o')
            ->where('e.eventDate > :now')
            ->setParameter('now', new \DateTime())
            ->orderBy('e.eventDate', 'ASC')
            ->getQuery()
            ->getResult();
    }

    public function findPopularEvents(int $limit = 10): array
    {
        return $this->createQueryBuilder('e')
            ->leftJoin('e.registrations', 'r')
            ->groupBy('e.id')
            ->orderBy('COUNT(r.id)', 'DESC')
            ->addOrderBy('e.eventDate', 'ASC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }
}
```

### **🗃️ Caching Strategy**
```php
// config/packages/cache.yaml
framework:
    cache:
        app: cache.adapter.filesystem
        default_redis_provider: redis://localhost

# src/Service/EventCacheService.php
class EventCacheService
{
    public function __construct(private CacheInterface $cache) {}

    public function getCachedEvents(): array
    {
        return $this->cache->get('upcoming_events', function (ItemInterface $item) {
            $item->expiresAfter(300); // 5 minutes
            
            return $this->eventRepository->findUpcomingWithRegistrations();
        });
    }
}
```

---

## 🌟 **Future Enhancements**

### **🚀 Planned Features**
- **💳 Payment Integration**: Stripe integration for paid events
- **📱 Mobile App**: React Native mobile application
- **🔔 Real-time Notifications**: WebSocket implementation
- **📊 Advanced Analytics**: Business intelligence dashboard
- **🌍 Multi-language Support**: Internationalization (i18n)
- **📧 Email Templates**: Rich HTML email templates
- **🎫 QR Code Tickets**: Digital ticket generation
- **📝 Event Reviews**: User feedback and rating system

### **⚡ Technical Roadmap**
- **API Development**: RESTful API for mobile apps
- **Microservices**: Event-driven architecture
- **Cloud Deployment**: AWS/Azure containerization
- **CI/CD Pipeline**: Automated testing and deployment
- **Performance Monitoring**: Application performance monitoring

---

## 📊 **Project Impact**

### **✅ Technical Achievements**
- **Modern PHP Architecture**: Symfony 6.0 with best practices
- **Secure Authentication**: Industry-standard security implementation
- **Database Design**: Normalized schema with proper relationships
- **Docker Integration**: Containerized development environment
- **Test Coverage**: Comprehensive testing strategy

### **🎯 Business Value**
- **Event Organization**: Streamlined event management process
- **User Engagement**: Interactive and user-friendly interface
- **Scalability**: Prepared for future feature expansion
- **Maintainability**: Clean and documented codebase
- **Security**: Robust security measures and data protection

---

## 📄 **License & Attribution**

MIT License - Feel free to use, modify, and distribute this project.

**Technologies Used:**
- PHP 8.0+ for backend development
- Symfony 6.0 for application framework
- Doctrine ORM for database management
- Twig for templating engine
- MySQL for data persistence

---

<div align="center">
  <h3>🎉 Making event management simple and efficient</h3>
  <p><strong>Created by Alfonso Cifuentes Alonso</strong></p>
  <p>🔗 <a href="https://github.com/AlfonsoCifuentes/mad-events">View on GitHub</a></p>
</div>
