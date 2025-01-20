<?php

namespace Tests\Unit;

use Pfrug\HashId\HashId;
use Jenssegers\Optimus\Optimus;
use Illuminate\Database\Eloquent\Model;
use PHPUnit\Framework\TestCase;

class HashIdTest extends TestCase
{
    /**
     * Test if the encodeId method works as expected.
     *
     * @return void
     */
    public function testEncodeId(): void
    {
        $optimusMock = $this->createMock(Optimus::class);
        $optimusMock->method('encode')->willReturn(123456);

        $model = $this->getMockForTrait(HashId::class);
        $model->optimus = $optimusMock;

        $encodedId = $model->encodeId(100);

        $this->assertEquals(123456, $encodedId);
    }

    /**
     * Test if the decodeId method works as expected.
     *
     * @return void
     */
    public function testDecodeId(): void
    {
        $optimusMock = $this->createMock(Optimus::class);
        $optimusMock->method('decode')->willReturn(100);

        $model = $this->getMockForTrait(HashId::class);
        $model->optimus = $optimusMock;

        $decodedId = $model->decodeId(123456);

        $this->assertEquals(100, $decodedId);
    }

    /**
     * Test if getRouteKey encodes the ID correctly.
     *
     * @return void
     */
    public function testGetRouteKey(): void
    {
        $optimusMock = $this->createMock(Optimus::class);
        $optimusMock->method('encode')->willReturn(123456);

        $model = $this->getMockForTrait(HashId::class);
        $model->optimus = $optimusMock;
        $model->id = 100;

        $routeKey = $model->getRouteKey();

        $this->assertEquals(123456, $routeKey);
    }

    /**
     * Test if resolveRouteBindingQuery decodes the ID correctly.
     *
     * @return void
     */
    public function testResolveRouteBindingQuery(): void
    {
        $optimusMock = $this->createMock(Optimus::class);
        $optimusMock->method('decode')->willReturn(100);

        $model = $this->getMockForTrait(HashId::class);
        $model->optimus = $optimusMock;

        // Simulando la llamada al método resolveRouteBindingQuery
        $queryMock = $this->createMock(Model::class);
        $value = '123456';
        $decodedValue = $model->resolveRouteBindingQuery($queryMock, $value);

        $this->assertEquals(100, $decodedValue);
    }
}
