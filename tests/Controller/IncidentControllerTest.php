<?php

namespace App\Test\Controller;

use App\Entity\Incident;
use App\Repository\IncidentRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class IncidentControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private IncidentRepository $repository;
    private string $path = '/backoffice/incident/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(Incident::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Incident index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'incident[createdAt]' => 'Testing',
            'incident[description]' => 'Testing',
            'incident[reporterEmail]' => 'Testing',
            'incident[reference]' => 'Testing',
            'incident[processedAt]' => 'Testing',
            'incident[resolveAt]' => 'Testing',
            'incident[rejectedAt]' => 'Testing',
        ]);

        self::assertResponseRedirects('/backoffice/incident/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Incident();
        $fixture->setCreatedAt('My Title');
        $fixture->setDescription('My Title');
        $fixture->setReporterEmail('My Title');
        $fixture->setReference('My Title');
        $fixture->setProcessedAt('My Title');
        $fixture->setResolveAt('My Title');
        $fixture->setRejectedAt('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Incident');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Incident();
        $fixture->setCreatedAt('My Title');
        $fixture->setDescription('My Title');
        $fixture->setReporterEmail('My Title');
        $fixture->setReference('My Title');
        $fixture->setProcessedAt('My Title');
        $fixture->setResolveAt('My Title');
        $fixture->setRejectedAt('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'incident[createdAt]' => 'Something New',
            'incident[description]' => 'Something New',
            'incident[reporterEmail]' => 'Something New',
            'incident[reference]' => 'Something New',
            'incident[processedAt]' => 'Something New',
            'incident[resolveAt]' => 'Something New',
            'incident[rejectedAt]' => 'Something New',
        ]);

        self::assertResponseRedirects('/backoffice/incident/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getReporterEmail());
        self::assertSame('Something New', $fixture[0]->getReference());
        self::assertSame('Something New', $fixture[0]->getProcessedAt());
        self::assertSame('Something New', $fixture[0]->getResolveAt());
        self::assertSame('Something New', $fixture[0]->getRejectedAt());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Incident();
        $fixture->setCreatedAt('My Title');
        $fixture->setDescription('My Title');
        $fixture->setReporterEmail('My Title');
        $fixture->setReference('My Title');
        $fixture->setProcessedAt('My Title');
        $fixture->setResolveAt('My Title');
        $fixture->setRejectedAt('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/backoffice/incident/');
    }
}
