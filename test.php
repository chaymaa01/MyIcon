// Example PHPUnit Test
use PHPUnit\Framework\TestCase;

class EventTest extends TestCase 
{
    public function testEventCreation()
    {
        $event = new Event();
        $event->setName('Test Event');
        
        $this->assertEquals('Test Event', $event->getName());
        $this->assertNotEmpty($event->getName());
    }
}
